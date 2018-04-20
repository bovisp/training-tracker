<template>
    <div>
        <div class="columns">
            <div class="column is-10">
                <div class="field">
                    <div class="control">
                        <label for="filter" class="label">Quick search query</label>

                        <input class="input" type="text" id="filter" v-model="quickSearchQuery">
                    </div>
                </div>
            </div>

            <div class="column is-2">
                {{ quickSearchQuery }}
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
                </tr>
            </thead>

            <tbody>
                <tr v-for="record in filteredRecords">
                    <td v-if="hasCheckbox">{{record[checkboxField]}}</td>

                    <td v-for="(columnValue, column) in record">
                        {{ columnValue }}
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
            quickSearchQuery: ''
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
                    console.log(this.trans(`app.table-columns.name`));
                })
        },

        getTranslatedColumnName (column) {
            return this.trans(`app.table-columns.${column}`)
        },

        sortBy (column) {
            this.sort.key = column

            this.sort.order = this.sort.order === 'asc' ? 'desc' : 'asc'
        }
    },

    mounted () {
        this.getRecords()
    }
}
</script>
