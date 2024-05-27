<template>
    <b-modal v-model="showModal" header-class="p-3 bg-light" :title="(!editable) ? 'Create User' : 'Edit User'" class="v-modal-custom" modal-class="zoomIn" centered no-close-on-backdrop>
        <form class="customform">
            <BRow class="g-3">
                <BCol lg="6" class="mt-3">
                    <InputLabel for="firstname" value="Firstname" :message="form.errors.firstname"/>
                    <TextInput id="firstname" v-model="form.firstname" type="text" class="form-control" autofocus placeholder="Please enter firstname" autocomplete="firstname" required @input="handleInput('firstname')" :light="true" />
                </BCol>
                <BCol lg="6" class="mt-3">
                    <InputLabel for="lastname" value="Lastname" :message="form.errors.lastname"/>
                    <TextInput id="lastname" v-model="form.lastname" type="text" class="form-control" autofocus placeholder="Please enter lastname" autocomplete="lastname" required @input="handleInput('lastname')" :light="true"/>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-n1 mb-n4"/></BCol>
                <BCol lg="12" class="mt-1 mb-n3">
                    <InputLabel for="email" value="Email" :message="form.errors.email"/>
                    <TextInput id="email" v-model="form.email" type="email" class="form-control" autofocus placeholder="Please enter email" autocomplete="email" required @input="handleInput('email')" :light="true"/>
                </BCol>
                <BCol lg="6">
                    <InputLabel for="username" value="Username" :message="form.errors.username"/>
                    <TextInput id="username" v-model="form.username" type="text" class="form-control" autofocus placeholder="Please enter username" autocomplete="email" required @input="handleInput('username')" :light="true"/>
                </BCol>
                
                <BCol lg="6">
                    <InputLabel for="mobile" value="Mobile" :message="form.errors.mobile"/>
                    <TextInput id="mobile" v-model="form.mobile" type="text" class="form-control" autofocus placeholder="Please enter mobile" autocomplete="mobile" required @input="handleInput('mobile')" :light="true"/>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-n1 mb-n3"/></BCol>
                <BCol lg="12" class="mt-1">
                    <InputLabel for="username" value="Role" :message="form.errors.role_id"/>
                    <Multiselect :options="dropdowns.roles" v-model="form.role" object :searchable="true" :message="form.errors.role" placeholder="Select Role" ref="multiselect1"/>
                </BCol>
                <BCol lg="12" v-if="has_designation && is_school" class="mt-1">
                    <InputLabel for="school" value="School" />
                    <Multiselect :options="schools" v-model="form.school" :searchable="true" :message="form.errors.school" placeholder="Select School" ref="multiselect2"/>
                </BCol>
                    <BCol lg="12" v-if="has_designation && !is_school" class="mt-1">
                    <InputLabel for="school" value="Province" />
                    <Multiselect :options="provinces" v-model="form.province" :searchable="true" :message="form.errors.province" placeholder="Select Province" ref="multiselect3"/>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-n1 mb-n3"/></BCol>
                <BCol lg="6"  style="margin-top: 13px; margin-bottom: -12px;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio1" class="custom-control-input me-2" value="Male" v-model="form.gender">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio1">Male</label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="custom-control custom-radio mb-3">
                                <input type="radio" id="customRadio2" class="custom-control-input me-2" value="Female" v-model="form.gender">
                                <label class="custom-control-label fw-normal fs-12" for="customRadio2">Female</label>
                            </div>
                        </div>
                    </div>
                </BCol>
                <BCol lg="12"><hr class="text-muted mt-n1 mb-n3"/></BCol>
            </BRow>
        </form>
          <template v-slot:footer>
            <b-button @click="hide()" variant="light" block>Cancel</b-button>
            <b-button @click="submit('ok')" variant="primary" :disabled="form.processing" block>Submit</b-button>
        </template>
    </b-modal>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Multiselect from '@/Shared/Components/Forms/Multiselect.vue'
import InputLabel from '@/Shared/Components/Forms/InputLabel.vue';
import TextInput from '@/Shared/Components/Forms/TextInput.vue';
export default {
    components: { InputLabel, TextInput, Multiselect },
    props: ['dropdowns'],
    data(){
        return {
            currentUrl: window.location.origin,
            form: useForm({
                id: null,
                firstname: null,
                lastname: null,
                username: null,
                email: null,
                mobile: null,
                gender: null,
                profile_id: null,
                school: null,
                province: null,
                role: null,
                role_id: null,
                region: this.dropdowns.region
            }),
            provinces: [],
            schools: [],
            has_designation: false,
            is_school: false,
            showModal: false,
            editable: false
        }
    },
     watch: {
        "form.role"(newVal){
            if(newVal){
                if(newVal.has_designation){
                    this.has_designation = 1
                    if(newVal.name == 'University Coordinator'){
                        this.is_school = true;
                        this.form.province = null;
                        this.fetchSchool(this.dropdowns.region);
                    }else{
                        this.is_school = false;
                        this.form.school = null;
                        this.fetchProvince(this.dropdowns.region);
                    }
                }else{
                    this.has_designation = 0
                }
                this.form.role_id = newVal.value;
            }else{
                this.has_designation = 0;
                this.form.role_id = null;
            }
        }
    },
    methods: { 
        show(){
            this.showModal = true;
        },
        edit(data){
            this.form.id = data.id;
            this.form.email = data.email;
            this.form.firstname = data.firstname;
            this.form.lastname = data.lastname;
            this.form.username = data.username;
            this.form.mobile = data.mobile;
            this.form.gender = data.gender;
            this.form.profile_id = data.profile_id,
            this.editable = true;
            this.showModal = true;
        },
        submit(){
            if(this.editable){
                this.form.put('/utility/users/update',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.hide();
                    },
                });
            }else{
                this.form.post('/utility/users',{
                    preserveScroll: true,
                    onSuccess: (response) => {
                        this.$emit('update',true);
                        this.hide();
                    },
                });
            }
        },
        handleInput(field) {
            this.form.errors[field] = false;
        },
        fetchSchool(code){
            axios.get('/lists/dropdowns',{ params: { option: 'schools', region: code } })
            .then(response => { this.schools = response.data.data; })
            .catch(err => console.log(err));
        },
        fetchProvince(code){
            axios.get('/lists/locations/',{ params: { option: 'list_province', code: code } })
            .then(response => { this.provinces = response.data; })
            .catch(err => console.log(err));
        },
        hide(){
            this.form.reset();
            this.form.clearErrors();
            this.$refs.multiselect1.clear();
            this.editable = false;
            this.showModal = false;
        }
    }
}
</script>