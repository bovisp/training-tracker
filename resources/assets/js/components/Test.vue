<template>
    <div class="container">
        <button @click="store">Add employees</button>

        <div v-for="(employee, index) in employees">
            <input type="checkbox" :id="employee.firstname + ' ' + employee.lastname" :value="employee.id" @change="checkboxChanged(employee, index)" :key="employee.id">
            <label :for="employee.firstname + ' ' + employee.lastname">{{employee.firstname + ' ' + employee.lastname}}</label>

            <select @change="selectionChanged(index, role[index])" v-model="role[index]">
                <option value=""></option>
                <option :value="role.type" v-for="role in roles" :key="role.id">{{ role.type }}</option>
            </select>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            employeesToBeAdded: [],
            employees: [],
            roles: [],
            role: []
        }
    },

    methods: {
        store() {
            let validatedEmployees = this.validate(this.employeesToBeAdded)

            axios.post("/api/users", validatedEmployees)
                .then(response => console.log(response))
            // let self = this

            // Object.keys(self.employeesToBeAdded).forEach(function(key) {
            //     console.log(self.employees[key].firstname);
            // });
        },

        selectionChanged(index, role) {
            if (!this.employeesToBeAdded[index]) {
                this.employeesToBeAdded[index] = {}
            }

            this.employeesToBeAdded[index]["role"] = role
        },

        checkboxChanged(employee, index) {
            if (!this.employeesToBeAdded[index]) {
                this.employeesToBeAdded[index] = {}
            }

            this.employeesToBeAdded[index]["id"] = employee.id
        },

        validate(employees) {
            return employees.filter(employee => Object.keys(employee).length !== 0)
        }
    },

    created() {
        axios.get("/api/users")
            .then(response => {
                this.employees = response.data.employees
                this.roles = response.data.roles
            })
    }
}
</script>
