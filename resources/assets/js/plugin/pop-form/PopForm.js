
export class PopForm {

	constructor () {
		this.formUrl = ''
        this.filterArray = []
	}

	setFormUrl(formUrl) {
        this.formUrl = formUrl
    }

    setFilterArray(filterArray) {
        this.filterArray = filterArray
    }

    beforeFn() {}

    afterAddFn() {}

    afterEditFn() {}

}
