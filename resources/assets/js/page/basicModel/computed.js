import {mapGetters} from 'vuex'

export default {

    computed: {

    	...mapGetters([
    		'navbarName',
    		'subNavBarName'
		]),

        modelUrlParams () {
            return this.$route.params.model
        },

        key () {
            return this.models[this.modelIndex].key
        },

        url () {
            return this.models[this.modelIndex].url
        },

        urlParams () {
            return this.models[this.modelIndex].urlParams
        },

        searchPlaceholder () {
            return this.models[this.modelIndex].searchPlaceholder
        },

        theads () {
            return this.models[this.modelIndex].theads
        },

        protos () {
            return this.models[this.modelIndex].protos
        },

        widths () {
            return this.models[this.modelIndex].widths
        },

        colComponent () {
            return this.models[this.modelIndex].colComponent
        },

        typeComponent () {
            return this.models[this.modelIndex].typeComponent
        },

        operateComponent () {
            return this.models[this.modelIndex].operateComponent
        },

        hideAddButton () {
            return this.models[this.modelIndex].hideAddButton
        },

        hideDeleteButton () {
            return this.models[this.modelIndex].hideDeleteButton
        },

        newComponent () {
            return this.models[this.modelIndex].newComponent
        }
    }

}