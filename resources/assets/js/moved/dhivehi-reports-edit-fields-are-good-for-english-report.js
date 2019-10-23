import Grid from './Grid';

const app = new Vue({
    el: "#app",
    data: {
        reportId: document.getElementById('report_id').value,
        criticalGrid: new Grid(['no', 'violation', 'recommendation']),
        criticalItems: [],
        criticalSelectedItem: null,
        criticalNewItem: null,
        majorGrid: new Grid(['no', 'violation', 'recommendation']),
        majorItems: [],
        majorSelectedItem: null,
        majorNewItem: null,
        observationsGrid: new Grid(['no', 'violation', 'recommendation']),
        observationsItems: [],
        observationsSelectedItem: null,
        observationsNewItem: null,
        dhivehiReportForm: new Form({
            scope: 1,
            critical: null,
            major: null,
            observations: null,
            areas: null,
            comments: null,
            inspectionMember1Name: null,
            inspectionMember1Designation: null,
            inspectionMember1Date: null,
            inspectionMember2Name: null,
            inspectionMember2Designation: null,
            inspectionMember2Date: null,
            verifiedByName: null,
            verifiedByDesignation: null,
            verifiedByDate: null,
        })
    },
    watch: {

    },
    mounted() {
        this.init()
    },
    methods: {
        /**general methods start**/
        init() {
            this.getReport();
        },
        getReport() {
            axios.get('/api/dhivehi/reports/' + this.reportId)
            .then(response => {
                console.log(response.data);
                this.setDhivehiReportFormFromResponse(response.data);
            })
            .catch(errors => {
                console.log('errors', errors);
            }); 
        },
        setDhivehiReportFormFromResponse(data) {
            this.setCriticalItems(data.critical);
            this.setMajorItems(data.major);
            this.setObservationsItems(data.observations);
            this.dhivehiReportForm.scope = data.scope;
            this.dhivehiReportForm.areas = data.areas;
            this.dhivehiReportForm.comments = data.comments;
            this.dhivehiReportForm.inspectionMember1Name = data.inspectionMember1Name;
            this.dhivehiReportForm.inspectionMember1Designation = data.inspectionMember1Designation;
            this.dhivehiReportForm.inspectionMember1Date = data.inspectionMember1Date;
            this.dhivehiReportForm.inspectionMember2Name = data.inspectionMember2Name;
            this.dhivehiReportForm.inspectionMember2Designation = data.inspectionMember2Designation;
            this.dhivehiReportForm.inspectionMember2Date = data.inspectionMember2Date;
            this.dhivehiReportForm.verifiedByName = data.verifiedByName;
            this.dhivehiReportForm.verifiedByDesignation = data.verifiedByDesignation;
            this.dhivehiReportForm.verifiedByDate = data.verifiedByDate;
        },

        prepareDhivehiReportForm() {
            this.updateDhivehiFormCritical();
            this.updateDhivehiFormMajor();
            this.updateDhivehiFormObservations();
        },

        saveDhivehiReportForm() {
            this.prepareDhivehiReportForm();
            this.dhivehiReportForm.patch('/dhivehi/reports/' + this.reportId)
            .then(response => {
                this.setDhivehiReportFormFromResponse(response.data);
            })
            .catch(errors => {
                console.log('errors', errors);
            }); 
        },

        
        /**
         * start of saving other fields
         */
        
        /**
         * Start of Critical, Major, Observations Store, Update and Delete
         * 
         * critical start
         */
        setCriticalItems(data = null) {
            if (data) {
                this.criticalGrid.setItems(data);
            }

            this.criticalItems =  this.criticalGrid.getItems();
            this.criticalSelectedItem = null;
        },
        criticalAddItem() {
            this.criticalSelectedItem = this.deselectCriticalSelectedItem();
            this.criticalNewItem = this.criticalGrid.newItem();
        },
        criticalStoreItem() {
            this.criticalGrid.add(this.criticalNewItem);
            this.criticalUpdateApi();
            this.criticalNewItem = null;
        },
        criticalRemoveItem(index) {
            this.criticalGrid.remove(index);
            this.criticalUpdateApi();
        },
        criticalEditItem(index) {
            this.criticalNewItem = null;
            this.criticalSelectItem(index);
        },
        criticalSelectItem(index) {
            this.criticalSelectedItem = {...this.criticalGrid.select(index)};
        },
        deselectCriticalSelectedItem() {
            this.criticalSelectedItem = this.criticalGrid.deSelect();
        },
        criticalUpdateItem() {
            this.criticalGrid.update(this.criticalSelectedItem);
            this.criticalUpdateApi();
            this.setCriticalItems();
        },
        updateDhivehiFormCritical() {
            this.dhivehiReportForm.critical = this.criticalGrid.getItems();
        },
        criticalUpdateApi() {
            // this.updateDhivehiFormCritical();
            this.saveDhivehiReportForm();
        },
        /**
         * major start
         */
        setMajorItems(data = null) {
            if (data) {
                this.majorGrid.setItems(data);
            }

            this.majorItems =  this.majorGrid.getItems();
            this.majorSelectedItem = null;
        },
        majorAddItem() {
            this.majorSelectedItem = this.deselectMajorSelectedItem();
            this.majorNewItem = this.majorGrid.newItem();
        },
        majorStoreItem() {
            this.majorGrid.add(this.majorNewItem);
            this.majorUpdateApi();
            this.majorNewItem = null;
        },
        majorRemoveItem(index) {
            this.majorGrid.remove(index);
            this.majorUpdateApi();
        },
        majorEditItem(index) {
            this.majorNewItem = null;
            this.majorSelectItem(index);
        },
        majorSelectItem(index) {
            this.majorSelectedItem = {...this.majorGrid.select(index)};
        },
        deselectMajorSelectedItem() {
            this.majorSelectedItem = this.majorGrid.deSelect();
        },
        majorUpdateItem() {
            this.majorGrid.update(this.majorSelectedItem);
            this.majorUpdateApi();
            this.setMajorItems();
        },
        updateDhivehiFormMajor() {
            this.dhivehiReportForm.major = this.majorGrid.getItems();
        },
        majorUpdateApi() {
            // this.updateDhivehiFormMajor();
            this.saveDhivehiReportForm();
        },
        /**
         * observations start
         */
        setObservationsItems(data = null) {
            if (data) {
                this.observationsGrid.setItems(data);
            }

            this.observationsItems =  this.observationsGrid.getItems();
            this.observationsSelectedItem = null;
        },
        observationsAddItem() {
            this.observationsSelectedItem = this.deselectObservationsSelectedItem();
            this.observationsNewItem = this.observationsGrid.newItem();
        },
        observationsStoreItem() {
            this.observationsGrid.add(this.observationsNewItem);
            this.observationsUpdateApi();
            this.observationsNewItem = null;
        },
        observationsRemoveItem(index) {
            this.observationsGrid.remove(index);
            this.observationsUpdateApi();
        },
        observationsEditItem(index) {
            this.observationsNewItem = null;
            this.observationsSelectItem(index);
        },
        observationsSelectItem(index) {
            this.observationsSelectedItem = {...this.observationsGrid.select(index)};
        },
        deselectObservationsSelectedItem() {
            this.observationsSelectedItem = this.observationsGrid.deSelect();
        },
        observationsUpdateItem() {
            this.observationsGrid.update(this.observationsSelectedItem);
            this.observationsUpdateApi();
            this.setObservationsItems();
        },
        updateDhivehiFormObservations() {
            this.dhivehiReportForm.observations = this.observationsGrid.getItems();
        },
        observationsUpdateApi() {
            // this.updateDhivehiFormObservations();
            this.saveDhivehiReportForm();
        }
        /**
         * End of Critical, Major, Observations Store, Update and Delete
         * used general methods saveDhivehiReportForm and prepareDhivehiReportForm 
         */
        

    }
});