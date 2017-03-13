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
                            label: '专家姓名',
                            rules: ['required', 'max:50'],
                            value: '',
                            placeholder: '必填'
                        },
                        expert_area_id: {
                            label: '专家领域',
                            options: [{}],
                            optionLabel: 'name',
                            optionValue: 'id',
                            value: '',
                            placeholder: '请选择专家领域'
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
                        degree: {
                            label: '学历',
                            rules: ['max:20'],
                            value: ''
                        },
                        address: {
                            label: '住址',
                            rules: ['max:50'],
                            value: ''
                        },
                        zipcode: {
                            label: '邮编',
                            rules: ['max:20'],
                            value: ''
                        },
                        company: {
                            label: '单位',
                            rules: ['max:50'],
                            value: ''
                        },
                        officephone: {
                            label: '办公电话',
                            rules: ['phones'],
                            value: ''
                        },
                        homephone: {
                            label: '宅电',
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
            this.getExpertAreas()
            this.$popForm.setFormUrl('expert')
            this.$popForm.setFilterArray(['sex'])
        },
        methods: {

            getOrgs () {
                axios.get(this.$adminUrl('org/query'))
                    .then((responce) => {
                        this.$set(this.rows.requireMsg.org_id, 'options', responce.data.data)
                    })
            },

            getExpertAreas () {
                axios.get(this.$adminUrl('normal-type?type=2'))
                    .then((responce) => {
                        this.$set(this.rows.requireMsg.expert_area_id, 'options', responce.data)
                    })
            }

        }
    }

</script>
