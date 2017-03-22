<template>
    <div>
        <edit :scope="scope" :model="model" class="btns"></edit>
        <div class="btns">
            <el-button
                size="small"
                @click="bindUser(scope)">绑定用户</el-button>
        </div>

        <el-dialog title="绑定用户" v-model="userDialogTableVisible" size="tiny">
            <!-- table data -->
            <el-table :data="users" highlight-current-row @row-click="handleUserSelectionChange">
                <el-table-column 
                    prop="name" 
                    label="用户名" 
                    show-overflow-tooltip>
                </el-table-column>
            </el-table>
            
            <!-- pagination -->
            <el-pagination
                small
                :current-page="paginator.current_page"
                :page-size="paginator.per_page"
                layout="prev, pager, next"
                :total="paginator.total"
                @current-change="pageChange"
                class="pagination">
            </el-pagination>

            <!-- dialog footer -->
            <div slot="footer" class="dialog-footer">
                <el-button @click="userDialogTableVisible = false">返回</el-button>
            </div>
        </el-dialog>

    </div>
</template>

<script>
    import {mapMutations} from 'vuex'
    import Edit from 'components/public/edit.vue'

    export default {
        name:'CrewHandle',
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
        data () {
            return {
                users: [],
                selectUser: null,
                paginator: {
                    current_page: 0,
                    total: 0,
                    per_page: 0
                },
                userDialogTableVisible: false,
                type: '',
                role: 1
            }
        },
        components: {
            Edit
        }, 
        mounted () {
            if('emergency_crew_created_at' in this.scope.row) {
                this.type = 'emergencycrew'
                this.role = 2
            }else {
                this.type = 'expert'
                this.role = 1
            }
    },
        methods: {

            ...mapMutations([
                'setFormMsg'
            ]),

            /**
             * 事件处理
             */
            bindUser ({ $index, row }) {
                this.userDialogTableVisible = true
                this.selectUser = row
                axios.get(this.$adminUrl('user/query?role=' + this.role))
                    .then((responce) => {
                        this.users = responce.data.data
                        this.paginator = responce.data
                    })
            },

            handleUserSelectionChange (val) {
                axios.post(this.$adminUrl(this.type + '/bindUser'), {id: this.selectUser.id, user_id: val.id})
                    .then((responce) => {
                        this.$message({
                          message: '绑定成功',
                          type: 'success'
                        })
                        this.userDialogTableVisible = false
                        this.selectUser.user_name = val.name
                        this.selectUser = null
                    })
            },

            pageChange (page) {
                axios.get(this.$adminUrl('user/query?page=') + page + '&role=' + this.role)
                    .then((responce) => {
                        this.users = responce.data.data
                        this.paginator = responce.data
                    })
            }
        }

    }
</script>

<style lang="sass" scoped>
    .btns {
        display: inline-block;
    }
</style>