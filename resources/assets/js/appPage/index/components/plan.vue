<template>
    <div v-transfer-dom>
        <x-dialog v-model="dialogVisible">
            <p class="dialog-title">{{msg.name}}</p>
            <div class="content">
                <ul>
                    <li>组长：{{leader | objectToString}}</li>
                    <li>副组长：{{subLeader | objectToString}}</li>
                    <li>成员：{{member | objectToString}}</li>
                </ul>
                <div>{{msg.content}}</div>
            </div>
            <span class="vux-close" @click="cancel"></span>
        </x-dialog>
    </div>
    
</template>

<script>

    import { XDialog, TransferDomDirective as TransferDom } from 'vux'

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
        directives: {
            TransferDom
        },
        components: {
            XDialog
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

<style lang="less" scoped>

    @import '~vux/src/styles/close';

    p {
        padding: 10px 0;
        background: linear-gradient(180deg,#e5e5e5,#e5e5e5,hsla(0,0%,90%,0)) 0 100% no-repeat;
        background-size: 100% 1px;
    }

    .content {
        padding-bottom: 2px;
        background: linear-gradient(180deg,#e5e5e5,#e5e5e5,hsla(0,0%,90%,0)) 0 100% no-repeat;
        background-size: 100% 1px;

        ul, div {
            width: 80%;
            margin: 9px auto;
            text-align: left;
        }
        
    }

    .vux-close {
        margin-top: 8px;
        margin-bottom: 8px;
    }
</style>
