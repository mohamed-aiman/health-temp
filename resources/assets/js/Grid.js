export default class Grid {

    constructor(keys = []) {
        this.fields = keys;
        this.items = [
            // { no: 0, key: 'something', value: 'some value1'},
            // { no: 1, key: 'something', value: 'some value2'},
            // { no: 2, key: 'something', value: 'some value3'},
            // { no: 3, key: 'something', value: 'some value4'},
            
        ];
        this.selectedItem = null;
    }

    select(index) {
        this.selectedIndex = index;
        return this.selectedItem = this.items.filter((item, key) => this.selectedItem = (key == index))[0];
    }
    deSelect() {
        return this.selectedIndex = this.selectedItem = null;
    }

    getSelectedItem() {
        return this.selectedItem;
    }

    setItems(data) {
        this.items = data;
    }

    getItems() {
        return this.items;
    }

    newItem(row = {}) {
        return this.setFields(row)
    }

    add(row = {}) {
        this.items.push(this.setFields(row));
    }

    setFields(row) {
        this.fields.forEach(function(field) {
            if(!row.hasOwnProperty(field)) {
                row[field] = null
            }
        });

        return row;
    }

    remove(index) {
        this.items.splice(index, 1);
    }

    update(data) {
        this.items[this.selectedIndex] = data;
    }
}