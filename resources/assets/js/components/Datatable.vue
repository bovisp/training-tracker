<template>
    <div>
        <div class="columns">
            <div class="column is-half">
                <div class="field">
                    <div class="control">
                        <label for="filter" class="label">Quick search</label>

                        <input class="input" type="text" id="filter" v-model="quickSearchQuery">
                    </div>
                </div>
            </div>

            <div class="column is-half is-flex">
                <button class="button is-link ml-auto self-end" @click="validate" v-if="postEndpoint">Add users</button>
            </div>
        </div>

        <div v-if="errors.length" class="message is-danger">
            <div class="message-body content">
                <ul class="mt-0">
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
        </div>

        <table class="table is-fullwidth is-sortable">
            <thead>
                <tr>
                    <th v-if="hasCheckbox">&nbsp;</th>

                    <th v-for="column in response.displayable">
                        <span @click="sortBy(column)">
                            <span>
                                {{ getTranslatedColumnName(column) }}
                            </span>

                            <span 
                                class="arrow" 
                                v-if="sort.key === column"
                                :class="{ 
                                    'arrow--asc': sort.order === 'asc',
                                    'arrow--desc': sort.order === 'desc'
                                }"
                            ></span>
                        </span>
                    </th>

                    <th v-if="actionButton">&nbsp;</th>

                    <th v-if="withRoles">Choose a role...</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="record in filteredRecords">
                    <td v-if="hasCheckbox">
                        <input 
                            type="checkbox" 
                            :value="record.id"
                            v-model="recordsModel[record.id]"
                        >
                    </td>

                    <td v-for="(columnValue, column) in record">
                        {{ columnValue }}
                    </td>

                    <td v-if="actionButton">
                        <a 
                            :href="actionButtonEndpoint + record['id'] + (actionButtonEndpointSuffix || '') "
                            class="button is-info is-small"
                        >
                            {{ actionButtonText }}
                        </a>
                    </td>

                    <td v-if="withRoles">
                        <div class="select">
                            <select v-model="roleModel[record.id]">
                                <option value=""></option>

                                <option :value="role.type" v-for="role in roles" :key="role.id">{{ role.name }}</option>
                            </select>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import orderBy from 'lodash.orderby'

export default {
    props: {
        endpoint: {
            type: String,
            required: true
        },
        hasCheckbox: {
            type: Boolean,
            required: false,
            default: false
        },
        checkboxField: {
            type: String,
            required: false,
            default: "id"
        },
        actionButton: {
            type: Boolean,
            required: false
        },
        actionButtonText: {
            type: String,
            required: false
        },
        actionButtonEndpoint: {
            type: String,
            required: false
        },
        actionButtonEndpointSuffix: {
            type: String,
            required: false
        },
        customHeaders: {
            type: Array,
            required: false
        },
        withRoles: {
            type: Boolean,
            required: false
        },
        rolesEndpoint: {
            type: String,
            required: false
        },
        postEndpoint: {
            type: String,
            required: false
        },
        successMessage: {
            type: String,
            required: false
        }
    },

    data () {
        return {
            response: {
                displayable: [],
                records: []
            },
            sort: {
                key: 'id',
                order: 'asc'
            },
            quickSearchQuery: '',
            recordsModel: [],
            roles: [],
            roleModel: [],
            errors: []
        }
    },

    computed: {
        filteredRecords () {
            let data = this.response.records

            data = data.filter((row) => {
                return Object.keys(row).some((key) => {
                    return String(row[key])
                        .toLowerCase()
                        .indexOf(this.quickSearchQuery.toLowerCase()) > -1
                })
            })

            if (this.sort.key) {
                data = orderBy(data, (i) => {
                    let value = i[this.sort.key]

                    if (!isNaN(parseFloat(value))) {
                        return parseFloat(value)
                    }

                    return String(i[this.sort.key]).toLowerCase()
                }, this.sort.order)
            }

            return data
        }
    },

    methods: {
        getRecords () {
            return axios.get(`${this.endpoint}`)
                .then(({data}) => {
                    this.response = data.data

                    if (this.customHeaders) {
                        this.response.displayable = this.customHeaders
                    }

                    if (this.withRoles) {
                        this.getRoles()
                    }

                    if (data.data.checked) {
                        data.data.checked.forEach(key => this.recordsModel[key] = true)
                    }
                })
        },

        getTranslatedColumnName (column) {
            return this.trans(`app.table-columns.${column}`)
        },

        sortBy (column) {
            this.sort.key = column

            this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc'
        },

        checkboxChanged (record) {
            if (!this.recordsModel[record.id]) {
                this.recordsModel[record.id] = {}
            }

            this.recordsModel[record.id]["id"] = record.id
        },

        getRoles () {
            axios.get('/roles/api')
                .then(({data}) => {
                    this.roles = data.data.records
                })
        },

        selectionChanged (record, role) {
            if (!this.recordsModel[record.id]) {
                this.recordsModel[record.id] = {}
            }

            this.recordsModel[record.id]["role"] = role
        },

        validate () {
            this.errors = []

            if (this.withRoles) {
                let records = this.validateSelectedRecords()

                this.validateSelectedRecordRoles()

                if (this.noRecordsAdded()) {
                    this.$toast.open({
                        message: `Please add some users.`,
                        position: 'is-top-right',
                        type: 'is-danger'
                    })
                }

                if (this.errors.length === 0 && records.filter(Boolean).length !== 0) {
                    this.postRecords(records)
                }
            } else {
                if (this.errors.length === 0) {
                    let records = [];

                    for (var i = this.recordsModel.length - 1; i >= 0; i--) {
                        if (this.recordsModel[i] === true) {
                            records.push({
                                id: i
                            })
                        }
                    }

                    this.postRecords(records)
                }
            }
        },

        validateSelectedRecords () {
            let records = [];

            Object.keys(this.recordsModel).forEach(key => {
                if (!this.roleModel[key] && this.recordsModel[key]) {
                    const user = this.findUserId(key)

                    this.errors.push(
                        `You have not chosen a role for ${user.firstname} ${user.lastname}`
                    )

                    return
                }

                records.push({
                    id: key,
                    role: this.roleModel[key]
                })
            })

            return records
        },

        validateSelectedRecordRoles () {
            Object.keys(this.roleModel).forEach(key => {
                if (!this.recordsModel[key] && this.roleModel[key]) {
                    const user = this.findUserId(key)

                    this.errors.push(
                        `You have not selected ${user.firstname} ${user.lastname} to be added, but you have selected a role. Please check the checkbox to the left of the user's name to add this person to the application`
                    )
                }
            })
        },

        noRecordsAdded () {
            return this.recordsModel.filter(Boolean).length === 0 && this.roleModel.filter(Boolean).length === 0
        },

        findUserId (key) {
            return this.response.records.find(user => user.id === parseInt(key))
        },

        postRecords (records) {
            axios.interceptors.response.use(
                response => {
                  return response;
                },
                error => {
                    return Promise.reject(error.response);
                }
            );

            axios.post(this.postEndpoint, records)
                .then(response => {
                    this.$toast.open({
                        message: this.successMessage,
                        position: 'is-top-right',
                        type: 'is-success'
                    })

                    // setTimeout(() => {
                    //     window.location = '/users';
                    // }, 3000)
                })
                .catch(error => {
                    if (error.status === 422) {
                        window.events.$emit('users-create-error', error.data.errors)
                    }
                })
        }
    },

    mounted () {
        this.getRecords()
    }
}
</script>
