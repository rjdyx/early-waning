<template>
    <el-dialog title="参与专家" v-model="dialogVisible" size="tiny" :show-close="false" :close-on-click-modal=false>
        <vue-perfect-scrollbar class="content">
            <ul>
                <li v-for="expert in experts">
                    {{expert.name}}
                </li>
            </ul>
        </vue-perfect-scrollbar>
        <span slot="footer" class="dialog-footer">
            <el-button @click="cancel">返 回</el-button>
        </span>
    </el-dialog>
</template>

<script>

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
        methods: {

            cancel () {
                this.$emit('cancel')
            }

        }
    }
</script>

<style lang="sass" scoped>

    .content {
        max-height: 150px;
        padding: 5px;

        ul {

            li {
                width: 100%;
                height: 35px;
                line-height: 35px;
                padding-left: 25px;
                margin-bottom: 3px;
            }

            li:hover {
                box-shadow: 0 0 6px 0px #bfcbd9;
            }
        }
    }

</style>
