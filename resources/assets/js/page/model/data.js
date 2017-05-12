export let indexDatas = [
    {
        indexName: '企业科技水平',
        remark: '对于企业来说，农业科技水平越高，其支出在总财政支出的比例越高，畜产品质量就越安全。',
        index: [
            {value: 9, desc: '占比大于60%'},
            {value: 7, desc: '占比在45%~60%之间'},
            {value: 5, desc: '占比在30%~45%之间'},
            {value: 3, desc: '占比在10%~30%之间'},
            {value: 1, desc: '占比小于10%'}
        ],
        more: false
    },
    {
        indexName: '检验检测能力',
        remark: '检验检测能力是监管部门的常规工作之一，可以对农产品的质量安全进行直接把关。监管设备的落后，相关设备的缺乏，会直接导致“检不出”、“检验结果错误”等低级错误，造成极大的资源浪费。',
        index: [
            {value: 9, desc: '拥有液相色谱仪及其以上级别的仪器、相关检测人员和确证法检验检测记录，或每年开展（产品和投入品）检验检测活动的企业'},
            {value: 7, desc: '拥有酶标仪，使用快速筛选法的企业'},
            {value: 5, desc: '定期开展（产品和投入品）检验检测活动，但使用的是试剂卡'},
            {value: 2, desc: '没有检验设备且不定期开展检验检测活动'}
        ],
        more: false
    },
    {
        indexName: '技术人员比重',
        remark: '技术人员比重在一定程度上体现了一个企业对科研的重视程度，也反映了企业的技术水平。其中，可以仅考虑企业是否拥有执业兽医师。',
        index: [
            {value: 9, desc: '执业兽医师'},
            {value: 7, desc: '兽医硕士生'},
            {value: 5, desc: '兽医本科生'},
            {value: 3, desc: '兽医专科生'},
            {value: 1, desc: '兽医专科生'}
        ],
        more: false
    },
    {
        indexName: '土壤质量',
        remark: '以国家制定的标准再结合区域土壤环境背景值作为评价标准。根据《土壤环境质量标准》(GB15618-2008)中的分级标准。',
        index: [
            {value: 9, desc: '土壤适用于国家规定的自然保护区、集中式生活饮用水源地、牧场和其他需要特别保护地区'},
            {value: 7, desc: '土壤中的污染物监测浓度低于筛选值。第三级土壤发生了实际污染危害，到达或超过了临界值'},
            {value: 1, desc: '污染'}
        ],
        more: false
    },
    {
        indexName: '用水安全',
        remark: '水是养殖中不可或缺的部分，不管是直接提供给畜禽饮用，还是混合到饲料里面，亦或是用于清洁，一旦有污染，则会直接影响到畜禽的健康。依照《地表水环境质量标准》（GB3838-2002）中的规定。',
        index: [
            {value: 9, desc: '适用于源头水，国家自然保护区'},
            {value: 7, desc: '适用于集中式生活饮用水、地表水源地一级保护区，珍稀水生生物栖息地，鱼虾类产卵场等'},
            {value: 5, desc: '适用于集中式生活饮用水、地表水源地二级保护区，鱼虾类越冬、回游通道，水产养殖区等渔业水域及游泳区'},
            {value: 3, desc: '适用于一般工业用水区及人体非直接解除的娱乐用水区'},
            {value: 1, desc: '适用于农业用水区及一般景观要求水域'}
        ],
        more: false
    },
    {
        indexName: '大气质量',
        remark: '作为无时无刻不在直接影响着畜禽健康的环境因素，大气质量显得尤为重要。依照《环境空气质量标准》(GB3095-2012)，环境空气功能区分为二类。',
        index: [
            {value: 9, desc: '自然保护区、风景名胜区和其他需要特殊保护的区域'},
            {value: 7, desc: '居住区、商业交通居民混合区、文化区、工业区和农村地区'},
            {value: 5, desc: '浓度限值等于二类'},
            {value: 3, desc: '浓度限值略高于二类'},
            {value: 1, desc: '浓度限值严重超出二类'}
        ],
        more: false
    },
    {
        indexName: '动物疫病发生情况',
        remark: '动物疫病的发生情况很直观地体现了畜禽产品的质量安全情况。畜禽发病得越频繁越严重，畜产品质量就越不安全。',
        index: [
            {value: 9, desc: ''},
            {value: 7, desc: ''},
            {value: 5, desc: ''},
            {value: 3, desc: ''},
            {value: 1, desc: ''}
        ],
        more: false
    },
    {
        indexName: '畜禽标准化养殖水平',
        remark: '畜禽标准化养殖水平体现在对各种药物残留的检验检测、对动物疾病疫病的防范与控制上。畜牧业经济的区域化布局、规模化生产，是实施标准化养殖的前提条件。标准化养殖水平越高，畜产品质量就越安全。',
        index: [
            {value: 9, desc: '省级标准化示范区'},
            {value: 7, desc: '市级标准化示范区'},
            {value: 5, desc: '按标准化生产的企业，主要看有没有检测标准和产品标准等'},
            {value: 3, desc: '没有完全按标准化生产的企业'},
            {value: 1, desc: '完全没有按标准化生产的企业'}
        ],
        more: false
    },
    {
        indexName: '饲料和饲料添加剂抽检合格率',
        remark: '饲料或饲料添加剂抽检合格率＝（抽检合格批次/抽检批次总数）*100%。',
        index: [
            {value: 9, desc: '大于等于95%'},
            {value: 7, desc: '介于90%~95%之间'},
            {value: 5, desc: '介于80%~90%之间'},
            {value: 3, desc: '介于70%~80%之间'},
            {value: 1, desc: '小于70%'}
        ],
        more: false
    },
    {
        indexName: '兽药和疫苗抽检合格率',
        remark: '兽药或疫苗抽检合格率＝（抽检合格批次/抽检批次总数）*100%。',
        index: [
            {value: 9, desc: '大于等于85%'},
            {value: 7, desc: '介于75%~85%之间'},
            {value: 5, desc: '介于65%~75%之间'},
            {value: 3, desc: '介于55%~65%之间'},
            {value: 1, desc: '小于55%'}
        ],
        more: false
    },
    {
        indexName: '农药使用情况',
        remark: '农药虽然不能直接影响畜产品质量安全，但是可以通过饲料作用到畜禽机体，从而导致畜产品质量安全事件的发生。对于农药，我们通过转化成对农产品的质量检测来度量。',
        index: [
            {value: 9, desc: '无公害'},
            {value: 7, desc: '绿色'},
            {value: 5, desc: '有机'},
            {value: 3, desc: '普通'},
            {value: 1, desc: '污染'}
        ],
        more: false
    },
    {
        indexName: '化肥使用情况',
        remark: '依据《肥料分级及要求》进行度量。',
        index: [
            {value: 9, desc: '生态级'},
            {value: 7, desc: '农田级'},
            {value: 5, desc: '园林级'},
            {value: 3, desc: '普通级'},
            {value: 1, desc: '污染'}
        ],
        more: false
    },
    {
        indexName: '包装材料安全水平',
        remark: '装材料的安全水平与包装材料本身、增塑剂、黏合剂、油墨以及微生物等因素有关，通过包装材料的合格率和包装方法的安全程度来衡量其整体水平。',
        index: [
            {value: 9, desc: '食品级包装材料、全程包装'},
            {value: 7, desc: '食品级包装材料、全程曾包装'},
            {value: 5, desc: '普通包装材料、全程曾包装'},
            {value: 3, desc: '仅做最简单的防污措施'},
            {value: 1, desc: '无包装'}
        ],
        more: false
    },
    {
        indexName: '贮藏保鲜设施水平',
        remark: '贮藏保鲜设施是农产品贮藏保鲜的基础条件，贮藏保鲜设施水平很大程度上影响了农产品产后到上市的质量损失，主要由简易场所条件、机械冷藏水平、气调和减压水平等来衡量。同时也需要考虑是全程冷链还是仅部分冷链。',
        index: [
            {value: 9, desc: ''},
            {value: 7, desc: ''},
            {value: 5, desc: ''},
            {value: 3, desc: ''},
            {value: 1, desc: ''}
        ],
        more: false
    },
    {
        indexName: '贮藏保鲜工艺技术',
        remark: '贮藏保鲜工艺是延缓产品贮藏期的关键因素，确定贮藏保鲜工艺条件是注册成功与否的关键，主要由贮藏方法的适宜程度及相关技术的先进水平决定。',
        index: [
            {value: 9, desc: ''},
            {value: 7, desc: ''},
            {value: 5, desc: ''},
            {value: 3, desc: ''},
            {value: 1, desc: ''}
        ],
        more: false
    },
    {
        indexName: '肉及肉制品合格率',
        remark: '肉及肉制品合格率＝（合格件数/监测件数）*100%。',
        index: [
            {value: 9, desc: '大于等于95%'},
            {value: 7, desc: '介于85%~95%之间'},
            {value: 5, desc: '介于81%~85%之间'},
            {value: 3, desc: '介于75%~81%之间'},
            {value: 1, desc: '小于75%'}
        ],
        more: false
    },
    {
        indexName: '食品安全事故级别',
        remark: '对于食品安全事故级别的确定，主要通过一定时间段内监测的不合格产品情况来衡量。',
        index: [
            {value: 9, desc: '0'},
            {value: 7, desc: '1'},
            {value: 5, desc: '2'},
            {value: 3, desc: '3'},
            {value: 1, desc: '食物中毒'}
        ],
        more: false
    }
]

export let modelValue = [
    {indexName: '企业科技水平', value: 0},
    {indexName: '检验检测能力', value: 0},
    {indexName: '技术人员比重', value: 0},
    {indexName: '土壤质量', value: 0},
    {indexName: '用水安全', value: 0},
    {indexName: '大气质量', value: 0},
    {indexName: '动物疫病发生情况', value: 0},
    {indexName: '畜禽标准化养殖水平', value: 0},
    {indexName: '饲料和饲料添加剂抽检合格率', value: 0},
    {indexName: '兽药和疫苗抽检合格率', value: 0},
    {indexName: '农药使用情况', value: 0},
    {indexName: '化肥使用情况', value: 0},
    {indexName: '包装材料安全水平', value: 0},
    {indexName: '贮藏保鲜设施水平', value: 0},
    {indexName: '贮藏保鲜工艺技术', value: 0},
    {indexName: '肉及肉制品合格率', value: 0},
    {indexName: '食品安全事故级别', value: 0}
]