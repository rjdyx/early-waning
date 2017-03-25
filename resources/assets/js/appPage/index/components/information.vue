<template>
    <div v-transfer-dom>
        <x-dialog v-model="dialogVisible">
            <p class="dialog-title">{{msg.name}}</p>
            <div class="content">
                <div>{{msg.content}}</div>
            </div>
            <span class="vux-close" @click="cancel"></span>
        </x-dialog>
    </div>
    
</template>

<script>

    import { XDialog, TransferDomDirective as TransferDom } from 'vux'

    export default {
        name: 'Information',
        props: {
            dialogVisible: false,
            msg: {
                type: Object,
                default () {
                    return {id: 0, name: '', content: ''}
                }
            }
        },
        directives: {
            TransferDom
        },
        components: {
            XDialog
        },
        methods: {

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

        div {
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
