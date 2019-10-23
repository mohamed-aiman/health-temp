const app = new Vue({
    el: "#app",
    data: {
        applicationId: document.getElementById('application_id').value,
        showNewBusinessRegistration: false,
        showAttachToExistingBusiness: true,
        searchForAnother: false,
        businessesSearchTerm: null,
        businesses: [],
        selectedBusiness: null,
        statusChangeStatus: null,
        statusChangeColor: 'is-success',
        application: {},
        license: {},
        businessStoreMessage: null,
        businessStoreColor: 'is-success',
        business: {},
        business_id: null,
        businessRegForm: {
            name: null,
            name_dv: null,
            phone: null,
            registration_no: null,
        },
        saveNewBusinessResponse: {},
        form: new Form({
            applicationId: null,
            _1tobaccoOrFood: "1",
            _1applicationType: "1",
            _1toRegisterPlace: true,
            _1toRenewLicense: true,
            _1registerPlace: "1",
            _1renewLicense: "1",
            _1registrationNumber: null,
            _1wantLicenseIndhivehi: true,
            _1wantLicenseInenglish: true,
            _1date:null,
            _2name:null,
            _2idNo:null,
            _2address:null,
            _2phone:null,
            _3name:null,
            _3idNo:null,
            _3address:null,
            _3phone:null,
            _4placeName:null,
            _4placeAddress:null,
            _4road:null,
            _4blockNumber:null,
            _4numberOfServingAreas:null,
            _4numberOfChairs:null,
            _5cat11:false,
            _5cat12:false,
            _5cat13:false,
            _5cat14:false,
            _5cat15:false,
            _5cat21:false,
            _5cat31:false,
            _5cat32:false,
            _5cat33:false,
            _5cat41:false,
            _5cat42:false,
            _5cat43:false,
            _5cat51:false,
            _5cat61:false,
            _5cat62:false,
            _5cat71:false,
            _5cat81:false,
            _5cat91:false,
            _5cat101:false,
            _5cat101text:null
        }),
        licenseForm: new Form({
            issued_at: new Date(),
            expire_at: new Date(),
            license_no: null,
        }),
        inspectionForm: new Form({
            date:new Date(),
            time: new Date(),
            datetimeString: '',
            dateString: '',
            timeString: ''
        })
    },
  watch: {
      'form._1applicationType': function() {
          switch(this.form._1applicationType) {
                case "1":
                    this.form._1toRegisterPlace = true;
                    this.form._1toRenewLicense = false;
                    break;
                case "2":
                    this.form._1toRegisterPlace = false;
                    this.form._1toRenewLicense = true;
                    break;
                default:
                    this.form._1toRegisterPlace = true
            }
      },
      businessesSearchTerm: _.debounce(function(){
          if (this.businessesSearchTerm) {
              this.businesses = [];
              this.searchBusinesses();
          }
      }, 700),
      'inspectionForm.time': function() {
          this.timePickerInput();
      }
    },
    mounted() {
        this.getApplication();
        this.datePickerInput();
        this.timePickerInput();
    },
    methods: {
        getApplication() {
            axios
              .get('/api/applications/' + this.applicationId)
                .then(response => {
                    this.setFormFromModel(response.data);
                })
                .catch(errors => console.log(errors));    
        },
        deleteApplication() {
            if (!confirm('Are you sure you want to delete this application?. You cannot undo this process.')) 
                return;

            axios
              .delete('/api/applications/' + this.applicationId)
                .then(response => {
                    window.location.href = '/applications/draft';
                })
                .catch(errors => console.log(errors));   
        },
        datePickerInput(date) {
            var date = (date) ? date: this.inspectionForm.date;
            // YYYY-MM-DD HH:MI:SS
            this.inspectionForm.dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
            console.log(this.inspectionForm.dateString);
        },
        buildDateTimeString() {
            return this.inspectionForm.datetimeString = this.inspectionForm.dateString + ' ' + this.inspectionForm.timeString;
        },
        timePickerInput() {
            if (this.inspectionForm.time) {
                var date = this.inspectionForm.time;
                this.inspectionForm.timeString = date.getHours() + ':' + this.pad(date.getMinutes()) + ':' + '00';
                console.log(this.inspectionForm.timeString);
            }
        },
        pad(value) {
            if(value < 10) {
                return '0' + value;
            } else {
                return value;
            }
        },
        formatDate(date) {
            return date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate() + ' 00:00:00';
        },
        submitSaveInspection() {
            axios
            .post('/api/applications/' + this.applicationId + '/inspections', {
                'inspection_at': this.buildDateTimeString()
            })
            .then(response => {
                console.log(response.data);
                this.setFormFromModel(response.data);
            })
            .catch(errors => {
                console.log('errors', errors);
                this.businessStoreFail();
            });    
        },
        saveLicenseForm() {
            axios
            .post('/api/applications/' + this.applicationId + '/licenses', {
                issued_at: this.formatDate(this.licenseForm.issued_at),
                expire_at: this.formatDate(this.licenseForm.expire_at),
                license_no: this.licenseForm.license_no
            })
            .then(response => {
                this.setFormFromModel(response.data);
            })
            .catch(errors => {
                console.log('errors', errors);
                this.businessStoreFail();
            });        
        },
        searchBusinesses() {
            axios
          .get('/api/businesses/search?found=true&term=' + this.businessesSearchTerm)
            .then(response => {
                this.businesses = response.data;
              if (this.businesses.length == 1) {
                  this.selectedBusiness = this.businesses[0];
              }
                    console.log(response.data);
            })
            .catch(error => console.log(error));
        },
        selectBusiness(item) {
            this.selectedBusiness = item;
            this.businesses = [];
        },
        toggleShowNewBusinessRegistration() {
            this.showNewBusinessRegistration = !this.showNewBusinessRegistration;
            this.searchForAnother = false;
        },
        togglelSearchForAnother() {
            this.searchForAnother = !this.searchForAnother;
            this.showNewBusinessRegistration = false;
        },
        setBusinessRegistrationRelated() {
            if(this.business == null) {
                this.businessRegForm.name = null;
                this.businessRegForm.name_dv = this.form._2name;
                this.businessRegForm.phone = this.form._2phone;
                this.businessRegForm.registration_no = this.form._1registrationNumber;
                this.businessesSearchTerm = this.form._1registrationNumber;
            } else {
                this.businessRegForm.name = this.business.name;
                this.businessRegForm.name_dv = this.business.name_dv;
                this.businessRegForm.phone = this.business._2phone;
                this.businessRegForm.registration_no = this.business.registration_no;
            }
        },
        submitNewBusinessForm() {
            axios.post('/api/applications/' + this.applicationId + '/businesses', this.businessRegForm)
                .then(response => {
                    this.setFormFromModel(response.data);
                    this.saveNewBusinessResponse = response;
    
                    setTimeout(function() {
                        this.$emit('update:saveNewBusinessResponse', {});
                    }.bind(this), 1000);
                })
                .catch(error => {
                    console.log(error.response);
                    this.saveNewBusinessResponse = error.response;
                });    
        },
        businessStoreFail() {
            this.businessStoreColor = 'is-danger';
            this.businessStoreMessage = 'error while creating new business entity or attaching it to the business.'
        },
        onSubmit() {
            this.form.patch('/applications/' + this.applicationId)
                .then(response => {
                    console.log(response);
                    this.setFormFromModel(response);
                })
                .catch(errors => console.log(errors));        
        },
        setFormFromModel(data) {
            this.application = data;
            this.license = this.application.license;
            this.business = data.business;
            this.business_id = data.business_id;

            if(this.license) {
                this.licenseForm.issued_at = new Date(this.license.issued_at);
                this.licenseForm.expire_at = new Date(this.license.expire_at);
                this.licenseForm.license_no = this.license.license_no;
            }

            this.form._1tobaccoOrFood = data._1tobaccoOrFood;
            this.form._1applicationType = data._1applicationType;
            this.form._1toRegisterPlace = data._1toRegisterPlace;
            this.form._1toRenewLicense = data._1toRenewLicense;
            this.form._1registerPlace = data._1registerPlace;
            this.form._1renewLicense = data._1renewLicense;
            this.form._1registrationNumber = data._1registrationNumber;
            this.form._1wantLicenseIndhivehi = data._1wantLicenseIndhivehi;
            this.form._1wantLicenseInenglish = data._1wantLicenseInenglish;
            this.form._1date = data._1date;
            this.form._2name = data._2name;
            this.form._2idNo = data._2idNo;
            this.form._2address = data._2address;
            this.form._2phone = data._2phone;
            this.form._3name = data._3name;
            this.form._3idNo = data._3idNo;
            this.form._3address = data._3address;
            this.form._3phone = data._3phone;
            this.form._4placeName = data._4placeName;
            this.form._4placeAddress = data._4placeAddress;
            this.form._4road = data._4road;
            this.form._4blockNumber = data._4blockNumber;
            this.form._4numberOfServingAreas = data._4numberOfServingAreas;
            this.form._4numberOfChairs = data._4numberOfChairs;
            this.form._5cat11 = data._5cat11;
            this.form._5cat12 = data._5cat12;
            this.form._5cat13 = data._5cat13;
            this.form._5cat14 = data._5cat14;
            this.form._5cat15 = data._5cat15;
            this.form._5cat21 = data._5cat21;
            this.form._5cat31 = data._5cat31;
            this.form._5cat32 = data._5cat32;
            this.form._5cat33 = data._5cat33;
            this.form._5cat41 = data._5cat41;
            this.form._5cat42 = data._5cat42;
            this.form._5cat43 = data._5cat43;
            this.form._5cat51 = data._5cat51;
            this.form._5cat61 = data._5cat61;
            this.form._5cat62 = data._5cat62;
            this.form._5cat71 = data._5cat71;
            this.form._5cat81 = data._5cat81;
            this.form._5cat91 = data._5cat91;
            this.form._5cat101 = data._5cat101;
            this.form._5cat101text = data._5cat101text;
            this.setBusinessRegistrationRelated();
        },
        sendForProcessing() {
            axios
            .patch("/api/applications/" + this.applicationId  + "/status/pending")
            .then(response => {
                item = response.data;
                this.statusChangeColor = 'is-success';
                this.statusChangeStatus = 'status changed successfully.'
                this.goToApplication();
            })
            .catch(error => {
                this.statusChangeStatus = 'error changing status: ' + error.response.data.message;
                this.statusChangeColor = 'is-danger';
            });
        },
        goToApplication() {
            window.location.href = '/applications/' + this.applicationId;
        },
        submitAttachToSelectedBusiness() {
                axios
                .patch('/api/applications/' + this.applicationId + '/businesses/' + this.selectedBusiness.id + '/attach')
                .then(response => {
                    this.setFormFromModel(response.data);
                })
                .catch(errors => {
                });
        },
        submitRemoveBusinessFromApplication() {
            if (confirm('Are you sure you want to detach this application from the attached business?')) {
                axios
                .patch('/api/applications/' + this.applicationId + '/businesses/detach')
                .then(response => {
                    this.setFormFromModel(response.data);
                })
                .catch(errors => {
                });
            } else {}
        },
    }
});