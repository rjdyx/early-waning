<template>
    <div>
        <el-button
            size="small"
            @click="triggleUser">{{btnMsg}}</el-button>
    </div>
</template>

<script>

    export default {
        name:'Lock',
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
        computed: {
            btnMsg () {
                return this.scope.row.active == 0?'冻结':'解冻'
            }
        },
        methods: {


            /**
            * 冻结或解冻
            */
            triggleUser () {
                axios.get(this.$adminUrl('user/triggleUser') + '/' + this.scope.row.id).then((response) => {
                    if(response.data){
                        if(this.scope.row.active == 0){
                            this.scope.row.active = 1
                            this.$message({
                              message: '冻结成功',
                              type: 'success'
                            })
                        }else {
                            this.scope.row.active = 0
                            this.$message({
                              message: '解冻成功',
                              type: 'success'
                            })
                        }
                    }
                })
            }
        }

    }
</script>
