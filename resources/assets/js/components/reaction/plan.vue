<template>
    <el-dialog v-model="dialogVisible" size="tiny" :show-close="false" :close-on-click-modal=false>
        <div class="plan">
            <h1>{{msg.name}}</h1>
            <ul>
                <li>组长：{{leader | objectToString}}</li>
                <li>副组长：{{subLeader | objectToString}}</li>
                <li>成员：{{member | objectToString}}</li>
            </ul>
            <div>{{msg.content}}</div>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button @click="cancel">返 回</el-button>
        </span>
    </el-dialog>
</template>

<script>

    export default {
        name: 'Plan',
        props: {
            dialogVisible: false,
            msg: {
                type: Object,
                default () {
                    return {id: 0, name: '', content: ''}
                }
            }
        },
        data () {
            return {
                leader: [],
                subLeader: [],
                member: []
            }
        },
        watch: {
            dialogVisible (val) {
                if(val) {
                    this.getCrew()
                }
            }
        },
        methods: {

            getCrew () {
                axios.get(this.$adminUrl('emergencycrew/query-crew/') + this.msg.id)
                    .then((responce) => {
                        this.$set(this, 'leader', responce.data.leader)
                        this.$set(this, 'subLeader', responce.data.subLeader)
                        this.$set(this, 'member', responce.data.member)
                    })
            },

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
