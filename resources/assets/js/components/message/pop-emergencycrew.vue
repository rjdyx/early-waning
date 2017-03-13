<template>
    <pop-form-tabs
        :rows="rows" 
        :editForm="form" 
        :edit="edit"
        @addSuccess="$emit('addSuccess')"
    ></pop-form-tabs>
</template>

<script>

    import SelectSex from 'components/public/select-sex.vue'

    export default {
        name: 'PopExpert',
        props: {
            form: {
                type: Object,
                default() {
                    return {}
                }
            },
            // 表示此模块是编辑模块还是新增模块的标志
            edit: {
                type: Boolean,
                default: false
            },
        },
        data () {
            return {
                rows: {
                    requireMsg: {
                        name: {
                            label: '应急人员姓名',
                            rules: ['required', 'max:50'],
                            value: '',
                            placeholder: '必填'
                        },
                        org_id: {
                            label: '所属机构',
                            options: [{}],
                            optionLabel: 'name',
                            optionValue: 'id',
                            value: '',
                            placeholder: '请选择机构'
                        },
                        sex: {
                            label: '性别',
                            component: SelectSex,
                            value: 1
                        },
                        duty: {
                            label: '职责',
                            rules: ['required', 'max:20'],
                            value: '',
                            placeholder: '必填'
                        },
                        title: {
                            label: '职务',
                            rules: ['required', 'max:20'],
                            value: '',
                            placeholder: '必填'
                        }
                    },

                    detailMsg: {
                        age: {
                            label: '年龄',
                            rules: ['decimal:0'],
                            value: 18
                        },
                        phone: {
                            label: '固定电话',
                            rules: ['phone'],
                            value: ''
                        },
                        cellphone: {
                            label: '手机',
                            rules: ['cellphone'],
                            value: ''
                        },
                        email: {
                            label: '邮箱',
                            rules: ['email'],
                            value: ''
                        },
                        meno: {
                            label: '备注',
                            rules: ['max:255'],
                            value: ''
                        }
                    }
                }
            }
        },
        mounted () {
            this.getOrgs()
            this.$popForm.setFormUrl('emergencycrew')
            this.$popForm.setFilterArray(['sex'])
        },
        methods: {

            getOrgs () {
                axios.get(this.$adminUrl('org/query'))
                    .then((responce) => {
                        this.$set(this.rows.requireMsg.org_id, 'options', responce.data.data)
                    })
            }

        }
    }

</script>
