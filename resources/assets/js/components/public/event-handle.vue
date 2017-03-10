<template>
    <div class="btns">
        <edit-event :scope="scope" :model="model"></edit-event>
        <div>
            <el-button
                size="small"
                @click="handleEvent(scope)">处理</el-button>
        </div>
    </div>
</template>

<script>
    import {mapMutations} from 'vuex'
    import EditEvent from './edit-event.vue'

    export default {
        name:'EventHandle',
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
        components: {
            EditEvent
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
                this.$router.push('/index/event-handle/handle-' + this.model.urlParams.status + '/edit')
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