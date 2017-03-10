<template>
    <router-link v-if="!hideAddButton" :to="'/index/new-form/' + model.url + '-' + params.status + '/new'" exact>
        <el-button type="primary" icon="plus">新增</el-button>
    </router-link>
</template>

<script>

    export default {
        name:'Add',
        props:{
            params: {
                type: Object,
                required: true,
                default () {
                    return {}
                }
            },
            model: {
                type: Object,
                required: true,
                default () {
                    return {}
                }
            }
        },
        methods: {

        }

    }
</script>
