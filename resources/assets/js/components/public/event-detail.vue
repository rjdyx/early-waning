<template>
    <div class="btns">
        <div>
            <el-button
                size="small"
                @click="handleEvent(scope)">查看进度</el-button>
        </div>
    </div>
</template>

<script>
    import {mapMutations} from 'vuex'

    export default {
        name:'EventDetail',
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
             * 事件处理
             */
            handleEvent ({ $index, row }) {
                this.setFormMsg(row)
                this.$router.push('/index/event-progress/progress-' + this.model.urlParams.status + '/edit')
            }
        }

    }
</script>

<style lang="sass" scoped>
    .btns {
        div {
            display: inline-block;
        }
    }
</style>