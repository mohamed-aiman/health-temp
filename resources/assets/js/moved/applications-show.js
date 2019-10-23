const app = new Vue({
    el: "#app",
    data: {
        applicationId: document.getElementById('application_id').value,
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
        })
    },
    mounted() {
        this.getApplication();
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
        setFormFromModel(data) {
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
        }
    }
});