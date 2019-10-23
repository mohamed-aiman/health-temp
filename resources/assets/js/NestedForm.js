import Form from './Form';

class NestedForm extends Form
{
	constructor(data) {
		super(data);
		this.collection = [];
	}

	delete(index) {
		this.collection.splice(index,1);
	}
}

export default NestedForm;