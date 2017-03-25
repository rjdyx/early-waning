<template>
    <div v-transfer-dom>
        <x-dialog v-model="dialogVisible">
            <p class="dialog-title">参与专家</p>
            <div class="content">
                <ul>
                    <li v-for="expert in experts">
                        {{expert.name}}
                    </li>
                </ul>
            </div>
            <span class="vux-close" @click="cancel"></span>
        </x-dialog>
    </div>
    
</template>

<script>

    import { XDialog, TransferDomDirective as TransferDom } from 'vux'

    export default {
        name: 'Expert',
        props: {
            dialogVisible: false,
            experts: {
                type: Array,
                default () {
                    return {id: 0, name: ''}
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

        ul {
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

