<template>
    <div class="container">
        <div class="container">
            <grid-component></grid-component>
            <table border="1">
                <tr>
                    <th>#</th>
                    <th>attributes</th>
                    <th>value</th>
                    <th>index</th>
                    <th>options</th>
                </tr>
                <tr>
                    <th><input type="text" name="no" v-model="selectedItem.no"/></th>
                    <th><input type="text" name="attributes" v-model="selectedItem.key"/></th>
                    <th><input type="text" name="value" v-model="selectedItem.value"/></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr v-for="item, index in items">
                    <td>{{item.no}}</td>
                    <td>{{item.key}}</td>
                    <td>{{item.value}}</td>
                    <td>{{index}}</td>
                    <td>
                        <button @click="remove(index)">Remove</button>
                        <button @click="edit(index)">edit</button>
                        <button @click="select(index)">select</button>
                    </td>
                </tr>
            </table>
            <br>
            <button @click="add">ADD</button>
            <button @click="test">TEST</button>
        </div>
    </div>
</template>

<script>
    import Grid from '../../Grid';
    export default {
        name: "GridComponent",
        props: {
            grid: Grid(['no', 'key', 'value']),
            items: [],
            selectedItem: Object
        },
        mounted() {
            this.init()
        },
        methods: {
            init() {
                this.items = this.grid.getItems();
                this.selectedItem = this.grid.selected;
            },
            test() {
            },
            add() {
                this.grid.add();
            },
            remove(index) {
                this.grid.remove(index);
            },
            edit(index) {
            },
            select(index) {
                this.selectedItem = this.grid.select(index);
            }
        }
    };
</script>
