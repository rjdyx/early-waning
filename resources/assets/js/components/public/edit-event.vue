<template>
    <div>
        <el-button
            size="small"
            @click="handleEdit(scope)">编辑</el-button>
    </div>
</template>

<script>
    import {mapMutations} from 'vuex'
    export default {
        name:'EditEvent',
        props:{
            scope: {
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

            ...mapMutations([
                'setFormMsg'
            ]),

            /**
             * 编辑
             */
            handleEdit ({ $index, row }) {
                this.setFormMsg(row)
                this.$router.push('/index/new-form/' + this.model.url + '-' + this.model.urlParams.status + '/edit')
            }
        }

    }
</script>
