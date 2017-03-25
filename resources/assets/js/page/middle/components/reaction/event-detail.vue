<template>
    <el-dialog v-model="dialogVisible" size="tiny" :show-close="false" :close-on-click-modal=false>
        <div class="plan">
            <h1>{{event.name}}</h1>
            <ul>
                <li>事件等级：{{event.event_level_name}}</li>
                <li>事件类别：{{event.event_sort_name}}</li>
                <li>发生地区：{{event.location}}</li>
            </ul>
            <div>{{event.detail}}</div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="cancel">返 回</el-button>
        </span>
    </el-dialog>
</template>

<script>

    export default {
        name: 'EventDetail',
        props: {
            dialogVisible: false,
            event: {
                type: Object,
                default () {
                    return {id: 0, name: '', content: ''}
                }
            }
        },
        methods: {

            cancel () {
                this.$emit('cancel')
            }

        }
    }
</script>

<style lang="sass" scoped>

    .plan {

        h1 {
            text-align: center;
            font-size: 20px;
        }

        ul {
            margin: 9px 0;
        }
        
    }

</style>
