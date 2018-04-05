<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('app.general.appName') }}</div>

                    <div class="panel-body" v-text="user.test[lang]">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import lang from '../mixins/lang';

export default {
    mixins: [lang],

    data() {
        return {
            user: {}
        }
    },

    mounted() {
        console.log(this.lang);
        axios.get("/users")
            .then(({data}) => {
                this.user = data
            })
        }
    }
</script>
