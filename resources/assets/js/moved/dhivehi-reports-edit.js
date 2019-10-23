import Grid from './Grid';

const app = new Vue({
    el: "#app",
    data: {
        reportId: document.getElementById('report_id').value,
        points: [],
        criticalPoints:[],
        majorPoints:[],
        minorPoints:[],
        showCriticalNewItemForm: false,
        showMajorNewItemForm: false,
        showMinorNewItemForm: false,
        newItem: {
            'type': null,
            'no': null,
            'code': null,
            'point_no': null,
            'violation': null,
            'recommendation': null,
        },
        statusChangeStatus: null,
        statusChangeColor: 'is-success',
        criticalItems: [],
        criticalSelectedItem: null,

        majorItems: [],
        majorSelectedItem: null,
        minorItems: [],
        minorSelectedItem: null,
        tobaccoGrid: new Grid(['no', 'reference', 'violation', 'recommendation']),
        tobaccoItems: [],
        tobaccoSelectedItem: null,
        tobaccoNewItem: null,
        // dhivehiReportForm: new Form({
        // }),
        dhivehiReportForm: {
            purpose: null,

            place_name_address: null,
            place_owner_name_address: null,
            phone: null,
            information_provider: null,
            number_of_inspections: null,
            time_of_inspection: null,
            
            critical: null,
            major: null,
            minor: null,
            tobacco: null,
            fine_slip_numbers: null,

            critical_totals: {
                fixed: null,
                to_be_fixed: null,
                total: null
            },
            major_totals: {
                fixed: null,
                to_be_fixed: null,
                total: null
            },
            minor_totals: {
                fixed: null,
                to_be_fixed: null,
                total: null
            },
            tobacco_totals: {
                fixed: null,
                to_be_fixed: null,
                total: null
            },

            food_conclusion_1: false,
            food_conclusion_2: false,
            food_conclusion_3: false,
            food_conclusion_3_date: null,
            food_conclusion_4: false,
            food_conclusion_5: false,
            food_conclusion_6: false,
            food_conclusion_6_amount: null,

            tobacco_conclusion_1: false,
            tobacco_conclusion_1_date: null,
            tobacco_conclusion_2: false,
            tobacco_conclusion_3: false,
            tobacco_conclusion_3_amount: null,

            phi_head_conclusion_1: false,
            phi_head_conclusion_2: false,
            phi_head_conclusion_3: false,
            phi_head_conclusion_3_date: null,
            phi_head_conclusion_4: false,
            phi_head_name: null,
            phi_head_sign: null,
            phi_head_date: null,

            tpcs_head_conclusion_1: false,
            tpcs_head_conclusion_2: false,
            tpcs_head_conclusion_3: false,
            tpcs_head_conclusion_3_date: null,
            tpcs_head_conclusion_4: false,
            tpcs_head_name: null,
            tpcs_head_sign: null,
            tpcs_head_date: null,

            from_business_name: null,
            from_business_position: null,
            from_business_sign: null,
            from_business_date: null,

            from_hpa_name: null,
            from_hpa_position: null,
            from_hpa_sign: null,
            from_hpa_date: null,

            // areas: null,
            // comments: null,
            // inspectionMember1Name: null,
            // inspectionMember1Designation: null,
            // inspectionMember1Date: null,
            // inspectionMember2Name: null,
            // inspectionMember2Designation: null,
            // inspectionMember2Date: null,
            // verifiedByName: null,
            // verifiedByDesignation: null,
            // verifiedByDate: null,
        }
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
        sendForProcessing() {
            axios
              .patch('/dhivehi/reports/'+ this.reportId +'/status/pending')
            .then(response => {
                this.statusChangeColor = 'is-success';
                this.statusChangeStatus = 'status changed successfully.'
                this.goToReport();
            }).catch(error => {
                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
                this.statusChangeColor = 'is-danger';
                this.getReport();
            });
        },
        goToReport() {
            window.location.href='/dhivehi/reports/' + this.reportId;
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
            this.dhivehiReportForm.purpose = data.purpose;

            this.dhivehiReportForm.place_name_address = data.place_name_address;
            this.dhivehiReportForm.place_owner_name_address = data.place_owner_name_address;
            this.dhivehiReportForm.phone = data.phone;
            this.dhivehiReportForm.information_provider = data.information_provider;
            this.dhivehiReportForm.time_of_inspection = data.time_of_inspection;
            this.dhivehiReportForm.number_of_inspections = data.number_of_inspections;

            this.points = data.points;
            this.setCriticalPoints();
            this.setMajorPoints();
            this.setMinorPoints();
            this.setTobaccoItems(data.tobacco);
            
            this.dhivehiReportForm.fine_slip_numbers = data.fine_slip_numbers;

            this.setCriticalTotals(data.critical_totals);
            this.setMajorTotals(data.major_totals);
            this.setMinorTotals(data.minor_totals);
            this.setTobaccoTotals(data.tobacco_totals);

            this.dhivehiReportForm.food_conclusion_1 = data.food_conclusion_1;
            this.dhivehiReportForm.food_conclusion_2 = data.food_conclusion_2;
            this.dhivehiReportForm.food_conclusion_3 = data.food_conclusion_3;
            this.dhivehiReportForm.food_conclusion_3_date = data.food_conclusion_3_date;
            this.dhivehiReportForm.food_conclusion_4 = data.food_conclusion_4;
            this.dhivehiReportForm.food_conclusion_5 = data.food_conclusion_5;
            this.dhivehiReportForm.food_conclusion_6 = data.food_conclusion_6;
            this.dhivehiReportForm.food_conclusion_6_amount = data.food_conclusion_6_amount;
            this.dhivehiReportForm.tobacco_conclusion_1 = data.tobacco_conclusion_1;
            this.dhivehiReportForm.tobacco_conclusion_1_date = data.tobacco_conclusion_1_date;
            this.dhivehiReportForm.tobacco_conclusion_2 = data.tobacco_conclusion_2;
            this.dhivehiReportForm.tobacco_conclusion_3 = data.tobacco_conclusion_3;
            this.dhivehiReportForm.tobacco_conclusion_3_amount = data.tobacco_conclusion_3_amount;
            this.dhivehiReportForm.phi_head_conclusion_1 = data.phi_head_conclusion_1;
            this.dhivehiReportForm.phi_head_conclusion_2 = data.phi_head_conclusion_2;
            this.dhivehiReportForm.phi_head_conclusion_3 = data.phi_head_conclusion_3;
            this.dhivehiReportForm.phi_head_conclusion_3_date = data.phi_head_conclusion_3_date;
            this.dhivehiReportForm.phi_head_conclusion_4 = data.phi_head_conclusion_4;
            this.dhivehiReportForm.phi_head_name = data.phi_head_name;
            this.dhivehiReportForm.phi_head_sign = data.phi_head_sign;
            this.dhivehiReportForm.phi_head_date = data.phi_head_date;
            this.dhivehiReportForm.tpcs_head_conclusion_1 = data.tpcs_head_conclusion_1;
            this.dhivehiReportForm.tpcs_head_conclusion_2 = data.tpcs_head_conclusion_2;
            this.dhivehiReportForm.tpcs_head_conclusion_3 = data.tpcs_head_conclusion_3;
            this.dhivehiReportForm.tpcs_head_conclusion_3_date = data.tpcs_head_conclusion_3_date;
            this.dhivehiReportForm.tpcs_head_conclusion_4 = data.tpcs_head_conclusion_4;
            this.dhivehiReportForm.tpcs_head_name = data.tpcs_head_name;
            this.dhivehiReportForm.tpcs_head_sign = data.tpcs_head_sign;
            this.dhivehiReportForm.tpcs_head_date = data.tpcs_head_date;
            this.dhivehiReportForm.from_business_name = data.from_business_name;
            this.dhivehiReportForm.from_business_position = data.from_business_position;
            this.dhivehiReportForm.from_business_sign = data.from_business_sign;
            this.dhivehiReportForm.from_business_date = data.from_business_date;
            this.dhivehiReportForm.from_hpa_name = data.from_hpa_name;
            this.dhivehiReportForm.from_hpa_position = data.from_hpa_position;
            this.dhivehiReportForm.from_hpa_sign = data.from_hpa_sign;
            this.dhivehiReportForm.from_hpa_date = data.from_hpa_date;

            // this.dhivehiReportForm.areas = data.areas;
            // this.dhivehiReportForm.comments = data.comments;
            // this.dhivehiReportForm.inspectionMember1Name = data.inspectionMember1Name;
            // this.dhivehiReportForm.inspectionMember1Designation = data.inspectionMember1Designation;
            // this.dhivehiReportForm.inspectionMember1Date = data.inspectionMember1Date;
            // this.dhivehiReportForm.inspectionMember2Name = data.inspectionMember2Name;
            // this.dhivehiReportForm.inspectionMember2Designation = data.inspectionMember2Designation;
            // this.dhivehiReportForm.inspectionMember2Date = data.inspectionMember2Date;
            // this.dhivehiReportForm.verifiedByName = data.verifiedByName;
            // this.dhivehiReportForm.verifiedByDesignation = data.verifiedByDesignation;
            // this.dhivehiReportForm.verifiedByDate = data.verifiedByDate;
        },

        prepareDhivehiReportForm() {
            this.updateDhivehiFormTobacco();
        },

        saveDhivehiReportForm() {
            this.prepareDhivehiReportForm();
            // this.dhivehiReportForm.patch('/dhivehi/reports/' + this.reportId)
            axios.patch('/dhivehi/reports/' + this.reportId, this.dhivehiReportForm)
            .then(response => {
                this.setDhivehiReportFormFromResponse(response.data);
            })
            .catch(errors => {
                console.log('errors', errors);
            }); 
        },

        setCriticalPoints() {
            this.criticalPoints = this.points.filter(function(point) {
                if(point.code == 'CR') {
                    return point;
                }
            });
        },
        setMajorPoints() {
            this.majorPoints = this.points.filter(function(point) {
                if(point.code == 'MJ') {
                    return point;
                }
            });
        },
        setMinorPoints() {
            this.minorPoints = this.points.filter(function(point) {
                if(point.code == 'MN') {
                    return point;
                }
            });
        },

        handOverDhivehiReportForm() {

        },

        /**
         * start of saving other fields
         */
        /**
         * set totals
         */
        setCriticalTotals(data = null) {
            this.setTotals(this.dhivehiReportForm.critical_totals, data);
        },

        setMajorTotals(data = null) {
            this.setTotals(this.dhivehiReportForm.major_totals, data);
        },

        setMinorTotals(data = null) {
            this.setTotals(this.dhivehiReportForm.minor_totals, data);
        },

        setTobaccoTotals(data = null) {
            this.setTotals(this.dhivehiReportForm.tobacco_totals, data);
        },

        setTotals(object, data) {
            object.fixed = data.fixed;
            object.to_be_fixed = data.to_be_fixed;
            object.total = data.total;
        },
        resetNewItem() {
            this.newItem =  {
                'type': null,
                'no': null,
                'code': null,
                'point_no': null,
                'violation': null,
                'recommendation': null,
            };
        },

        resetSelectedItem(selectedItem) {
            selectedItem =  {
                'no': null,
                'point_no': null,
                'violation': null,
                'recommendation': null,
            };
        },

        storePoint(type) {
            this.newItem.code = type;
            axios.post('/api/dhivehi-reports/'+this.reportId+'/points', this.newItem)
                .then((response) => {
                    this.refreshPointsBlock(type);
                    this.resetNewItem();
                    console.log(response)
                })
                .catch(errors => console.log(response));
        },
        updatePoint(type, point) {
            axios.patch('/api/dhivehi-reports/'+this.reportId+'/points/' + point.id, point)
                .then((response) => {
                    this.refreshPointsBlock(type);
                    this.refreshSelectedItem(type);
                })
                .catch(errors => console.log(response));
        },
        removePoint(type, point) {
            if (!confirm('are you sure you want to delete this?')) return;

            axios.delete('/api/dhivehi-reports/'+this.reportId+'/points/' + point.id)
                .then((response) => {
                    this.refreshPointsBlock(type);
                })
                .catch(errors => console.log(response));
        },
        refreshPointsBlock(type) {
            axios.get('/api/dhivehi-reports/'+this.reportId+'/points?type=' + type)
                .then((response) => {
                    switch(type) {
                      case 'CR':
                        this.criticalSelectedItem = response.data;
                        break;
                      case 'MJ':
                        this.majorSelectedItem = response.data;
                        break;
                      case 'MN':
                        this.minorSelectedItem = response.data;
                        break;
                      default:
                    }
                })
                .catch(errors => console.log(response));
        },
        refreshSelectedItem(type) {
            switch(type) {
              case 'CR':
                this.resetSelectedItem(this.criticalSelectedItem);
                break;
              case 'MJ':
                this.resetSelectedItem(this.majorSelectedItem);
                break;
              case 'MN':
                this.resetSelectedItem(this.minorSelectedItem);
                break;
            }
        },

        
        /**
         * tobacco start
         */
        setTobaccoItems(data = null) {
            if (data) {
                this.tobaccoGrid.setItems(data);
            }

            this.tobaccoItems =  this.tobaccoGrid.getItems();
            this.tobaccoSelectedItem = null;
        },
        tobaccoAddItem() {
            this.tobaccoSelectedItem = this.deselectTobaccoSelectedItem();
            this.tobaccoNewItem = this.tobaccoGrid.newItem();
        },
        tobaccoStoreItem() {
            this.tobaccoGrid.add(this.tobaccoNewItem);
            this.tobaccoUpdateApi();
            this.tobaccoNewItem = null;
        },
        tobaccoRemoveItem(index) {
            this.tobaccoGrid.remove(index);
            this.tobaccoUpdateApi();
        },
        tobaccoEditItem(index) {
            this.tobaccoNewItem = null;
            this.tobaccoSelectItem(index);
        },
        tobaccoSelectItem(index) {
            this.tobaccoSelectedItem = {...this.tobaccoGrid.select(index)};
        },
        deselectTobaccoSelectedItem() {
            this.tobaccoSelectedItem = this.tobaccoGrid.deSelect();
        },
        tobaccoUpdateItem() {
            this.tobaccoGrid.update(this.tobaccoSelectedItem);
            this.tobaccoUpdateApi();
            this.setTobaccoItems();
        },
        updateDhivehiFormTobacco() {
            this.dhivehiReportForm.tobacco = this.tobaccoGrid.getItems();
        },
        tobaccoUpdateApi() {
            // this.updateDhivehiFormMajor();
            this.saveDhivehiReportForm();
        }
        /**
         * End of Critical, Major, Minor, Tobacco Store, Update and Delete
         * used general methods saveDhivehiReportForm and prepareDhivehiReportForm 
         */
        

    }
});