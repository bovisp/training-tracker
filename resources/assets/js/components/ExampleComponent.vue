<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('app.general.appName') }}</div>

                    <div class="panel-body">
                        {{ user.test }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user: {}
        }
    },

    created() {
        axios.get("/users")
            .then(({data}) => {
                this.user = data
                console.log(this.user);
            })
    }
}
</script>
