<template>
  <div>
    <div class="card">
      <div class="card-header">
        <div class="row g-4 align-items-center">
          <div class="col-sm-3">
            <form class="app-search d-md-block py-0 ps-0">
              <div class="position-relative">
                <input type="text" class="form-control" placeholder="Search..." v-model="search" @input="onSearch">
                <span class="ri-search-line search-icon search-widget-icon fs-14"></span>
                <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close cursor-pointer d-none" id="search-close" @click="searchClear"></span>
              </div>
            </form>
          </div>
          <div class="col-sm-auto ms-auto">
            <div class="hstack gap-2">
              <button type="button" class="btn btn-soft-info add-btn" id="create-btn" @click="newPatient"><i class="ri-add-line align-bottom me-1"></i> Add Patient</button>
              <button class="btn btn-soft-info btn-icon" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-more-2-fill"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary">
                <li><a class="dropdown-item disabled" id="contract-dw-1" href="javascript:void(0);" @click="viewContract()"><i class="ri-eye-fill align-bottom me-2 text-muted"></i>View</a></li>
                <li><a class="dropdown-item disabled" id="contract-dw-2" href="javascript:void(0);" @click="editContract()"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i>Edit</a></li>
                <li><a class="dropdown-item disabled" id="contract-dw-3" href="javascript:void(0);" @click="delContract()"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>Delete</a></li>
                <div class="dropdown-divider"></div>
                <li><a class="dropdown-item disabled" id="contract-dw-4" href="javascript:void(0);" @click="orderOpen()"><i class="ri-todo-fill align-bottom me-2 text-muted"></i>Orders</a></li>
                <li><a class="dropdown-item disabled" id="contract-dw-5" href="javascript:void(0);" @click="editAttachment()"><i class="ri-attachment-line align-bottom me-2 text-muted"></i>Attachments</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="table-responsive table-card">
          <table class="table align-middle table-nowrap mb-0">
            <thead class="table-light text-muted">
              <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Surname</th>
                <th>Company</th>
                <th>Department</th>
                <th>Position</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr v-for="item in userData.data" :key="item.id">
                <td>
                  <div class="d-flex gap-2 align-items-center">
                    <div v-if="item.avatar" class="flex-shrink-0">
                      <img :src="'assets/images/users/' + item.avatar" alt="" class="avatar-xs rounded-circle">
                    </div>
                    <div v-else class="avatar-xs">
                      <div class="avatar-title rounded bg-success-subtle text-muted rounded-circle text-capitalize fw-medium">{{ avatarText(item.name, item.surname) }}</div>
                    </div>
                    <div class="flex-grow-1">
                      <a class="fw-medium link-secondary text-body" href="javascript:void(0)" @click="userSelected(item.username, item.id)">{{ item.username }}</a>
                    </div>
                  </div>
                </td>
                <td>{{ item.name }}</td>
                <td>{{ item.surname }}</td>
                <td>{{ item.company }}</td>
                <td>{{ item.department }}</td>
                <td>{{ item.position }}</td>
                <td>{{ item.email }}</td>
                <td>{{ item.phone }}</td>
                <td>
                  <button class="btn btn-soft-success btn-icon btn-sm material-shadow-none dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-more-fill bx bx-dots-horizontal align-middle"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end" style="">
                    <li><a class="dropdown-item" href="javascript:void(0);" @click="userSelected(item.username, item.id)"><i class="ri-lock-unlock-fill align-bottom me-2 text-muted"></i> Authorise</a></li>
                    <li><a class="dropdown-item disabled" href="javascript:void(0);"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit User</a></li>
                    <li><a class="dropdown-item disabled" href="javascript:void(0);"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</a></li>
                  </ul>
                </td>
              </tr> -->
            </tbody>
          </table>
        </div>
        <div class="mt-4">
          <!-- <pagination :pagination="userData" @paginate="getUsers($event)" :offset="4"></pagination> -->
        </div>
      </div>
    </div>


    <!-- Add new patient -->
    <div class="modal fade" id="patient-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Contract</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-content border-0 mt-3">
            <ul class="nav nav-tabs nav-tabs-custom nav-success p-2 pb-0 bg-light" role="tablist">
              <li class="nav-item" role="presentation">
                <a class="nav-link active" id="add-patient-tab" data-bs-toggle="tab" href="#add-patient" role="tab" aria-selected="true">
                  Patient Info
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-treatment-tab" data-bs-toggle="tab" href="#add-treatment" role="tab" aria-selected="false">
                  Treatments
                </a>
              </li>
              <li class="nav-item" role="presentation">
                <a class="nav-link" id="add-medication-tab" data-bs-toggle="tab" href="#add-medication" role="tab" aria-selected="false">
                  Medications
                </a>
              </li>
            </ul>
          </div>
          <div class="modal-body">
            <div class="tab-content">
              <div class="tab-pane active show" id="add-patient" role="tabpanel">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="mb-3">
                      <label class="form-label">Name & Surname <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <button class="btn dropdown-toggle" type="button" style="border-color: var(--vz-input-border-custom);" data-bs-toggle="dropdown" aria-expanded="false">{{ patientForm.sex }}</button>
                        <ul class="dropdown-menu dropdownmenu-secondary">
                          <li><a class="dropdown-item" href="#" @click="patientForm.sex = 'Male'">Male</a></li>
                          <li><a class="dropdown-item" href="#" @click="patientForm.sex = 'Female'">Female</a></li>
                          <li><a class="dropdown-item" href="#" @click="patientForm.sex = 'LGBTQ'">LGBTQ</a></li>
                        </ul>
                        <input type="text" class="form-control" placeholder="Enter name and surname" aria-label="Text input with 2 dropdown buttons" v-model="patientForm.patient_name">
                        <button type="button" class="btn btn-icon" style="height: 37.5px; border-color: var(--vz-input-border-custom);" @click="newPhoto"><i class="bx bxs-camera align-middle fs-16"></i></button>
                      </div>
                      <input class="d-none" ref="photo" type="file" accept="image/*" @change="selectPhoto">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Company <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select company" :options="lkCompany" v-model="patientForm.company" @change="patientForm.department = ''" />
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3" v-if="patientForm.company == 'XPPL'">
                      <label class="form-label">Department <span class="text-danger">*</span></label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select department" :options="lkDept" v-model="patientForm.department" />
                    </div>
                    <div class="mb-3" v-else>
                      <label class="form-label">Subcontractor </label>
                      <input type="text" class="form-control" placeholder="Enter subcontractor" v-model="patientForm.department">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Position </label>
                      <multiselect :searchable="true" :searchStart="true" placeholder="Select position" :options="lkPosition" v-model="patientForm.position" />
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Employee ID</label>
                      <input type="text" class="form-control" placeholder="Enter employee id" v-model="patientForm.employee_id">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Age</label>
                      <input type="text" class="form-control" placeholder="Enter age" v-model="patientForm.age">
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="mb-3">
                      <label class="form-label">Blood Group </label>
                      <multiselect placeholder="Select" :options="lkBloodGroup" v-model="patientForm.blood_group" />
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Phone</label>
                      <input type="text" class="form-control" placeholder="Enter contact number" v-model="patientForm.phone">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Congenital Disease</label>
                      <input type="text" class="form-control" placeholder="Enter congenital disease" v-model="patientForm.disease">
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="mb-3">
                      <label class="form-label">Drug Allergies</label>
                      <input type="text" class="form-control" placeholder="Enter drug allergies" v-model="patientForm.drug_allergy">
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control" rows="2" placeholder="Enter notes" v-model="patientForm.note"></textarea>
                  </div>
                </div>
              </div>

              <!-- Treatments tab -->
              <div class="tab-pane" id="add-treatment" role="tabpanel">
                <div class="row">
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Date Time <span class="text-danger">*</span></label>
                      <input type="text" class="form-control flatpickr-input flatpickr-single cursor-pointer" placeholder="Select date" v-model="treatmentFrom.date_time">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Medical Type <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select medical type" :options="lkMedicalType" v-model="treatmentFrom.medical_type" @change="treatmentFrom.injury_type = ''" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3" v-if="treatmentFrom.medical_type == 'Accident'">
                      <label class="form-label">Injury Type <span class="text-danger">*</span></label>
                      <multiselect @change="treatmentFrom.injury_part = null" placeholder="Select injury type" :options="lkInjType" v-model="treatmentFrom.injury_type" />
                    </div>
                    <div class="mb-3" v-else>
                      <label class="form-label">Injury Type </label>
                      <input type="text" class="form-control" placeholder="Injury type" readonly>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Injury Part </label>
                      <multiselect v-if="treatmentFrom.injury_type" mode="tags" :searchable="true" :searchStart="true" :close-on-select="false" placeholder="Select injury parts" :options="lkInjPart" v-model="treatmentFrom.injury_part" />
                      <input v-else type="text" class="form-control" placeholder="Injury parts" readonly>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Work Related <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select work related" :options="lkRelated" v-model="treatmentFrom.work_related" />
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="mb-3">
                      <label class="form-label">Temp C</label>
                      <input type="text" class="form-control" placeholder="Temp c" v-model="treatmentFrom.temp_c">
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="mb-3">
                      <label class="form-label">BP</label>
                      <input type="text" class="form-control" placeholder="Blood press" v-model="treatmentFrom.blood_press">
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="mb-3">
                      <label class="form-label">Puls</label>
                      <input type="text" class="form-control" placeholder="Puls" v-model="treatmentFrom.puls">
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="mb-3">
                      <label class="form-label">Oxigen</label>
                      <input type="text" class="form-control" placeholder="Oxigen" v-model="treatmentFrom.oxigen">
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Weight</label>
                      <input type="text" class="form-control" placeholder="Weight" v-model="treatmentFrom.weight">
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="mb-3">
                      <label class="form-label">Syndrome <span class="text-danger">*</span></label>
                      <textarea class="form-control" rows="2" placeholder="Enter syndrome" v-model="treatmentFrom.syndrome"></textarea>
                    </div>
                  </div>
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Diagnosis <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select diagnosis" :searchable="true" :searchStart="true" :options="lkDiagnosis" v-model="treatmentFrom.diagnosis" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-3">
                      <label class="form-label">Patient Type <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select patient type" :options="lkPatientType" v-model="treatmentFrom.patient_type" @change="treatmentFrom.transfer = ''" />
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-lg-0 mb-3">
                      <label class="form-label">Transfer </label>
                      <multiselect v-if="treatmentFrom.patient_type == 'In Patient'" placeholder="Select transfer" :options="lkTransfer" v-model="treatmentFrom.transfer" @change="treatmentFrom.hospital = ''" />
                      <input v-else type="text" class="form-control" placeholder="Transfer" readonly>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-lg-0 mb-3">
                      <label class="form-label">Hospital </label>
                      <multiselect v-if="treatmentFrom.transfer" placeholder="Select hospital" :options="lkHospital" v-model="treatmentFrom.hospital" />
                      <input v-else type="text" class="form-control" placeholder="Hospital" readonly>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="mb-lg-0 mb-3">
                      <label class="form-label">Medic <span class="text-danger">*</span></label>
                      <multiselect placeholder="Select medic" :options="lkMedic" v-model="treatmentFrom.medic" />
                    </div>
                  </div>
                </div>
              </div>

              <!-- Medication Tab -->
              <div class="tab-pane" id="add-medication" role="tabpanel">
                <div class="row g-2">
                  <div class="col-lg-8">
                    <div class="mb-3">
                      <label class="form-label">Medicine Name <span class="text-danger">*</span></label>
                      <multiselect placeholder="Enter name and surname" :searchable="true" :searchStart="true" :options="lkMedicine" v-model="medicationForm.medicine_id" @select="setfocus" />
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <div class="mb-3">
                      <label class="form-label">Unit</label>
                      <input type="text" class="form-control" placeholder="Unit" v-model="medicationForm.unit_eng" readonly>
                    </div>
                  </div>
                  <div class="col-lg-2 col-6">
                    <label class="form-label">Qty</label>
                    <div class="input-group">
                      <input type="number" id="medication-qty" class="form-control" placeholder="Qty" v-model="medicationForm.qty">
                      <button type="button" class="btn btn-info btn-icon" :class="medicationDis" @click="addMedicationTemp"><i class="ri-add-line align-middle fs-18"></i></button>
                    </div>
                  </div>{{ unit }}
                </div>

                <div class="card-body mt-2" v-if="medicationTemp.length > 0">
                  <div class="table-responsive">
                    <table class="table align-middle border table-nowrap mb-0 table-sm">
                      <thead class="table-active text-muted">
                        <tr>
                          <th style="width: 30px;">#</th>
                          <th class="w-75">Medicine</th>
                          <th>Qty</th>
                          <th>Unit</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(item, index) in medicationTemp" :key="index">
                          <td>{{ index + 1 }}</td>
                          <td>{{ item.medicine }}</td>
                          <td>{{ item.qty }}</td>
                          <td>{{ item.unit_eng }}</td>

                          <td>
                            <div v-if="item.note == 'new'">
                              <button type="button" class="btn btn-sm btn-icon text-muted btn-sm material-shadow-none" @click="delMedicationTemp(index)"><i class="ri-delete-bin-line text-danger fs-16"></i></button>
                            </div>
                            <div v-else>
                              <a href="javascript:void(0);" class="btn btn-soft-success btn-sm btn-icon dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill"></i>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary" style="">
                                <li><a class="dropdown-item" href="javascript:void(0);" @click="downloadFile(item.new_name)"><i class="ri-download-2-fill me-2 align-bottom text-muted"></i>Download</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" @click="delFile(item.file_id, item.new_name, index)"><i class="ri-delete-bin-5-fill me-2 align-bottom text-muted"></i>Delete</a></li>
                              </ul>
                            </div>

                            <!-- <div class="d-flex gap-1">
                              <a href="javascript:void(0);" class="btn btn-soft-success btn-sm btn-icon dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-fill"></i>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-end dropdownmenu-secondary">
                                <li><a class="dropdown-item" href="javascript:void(0);" @click="editOrder(item.order_id)"><i class="ri-pencil-fill me-2 align-bottom text-muted"></i>Edit</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);" @click="delOrder(item.order_id, index)"><i class="ri-delete-bin-5-fill me-2 align-bottom text-muted"></i>Delete</a></li>
                              </ul>
                            </div> -->
                          </td>

                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer" style="display: block;">
            <div class="hstack gap-2 justify-content-end">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ $t('close-btn') }}</button>
              <button type="button" class="btn btn-success" :class="addPatientDis" @click="addPatient">Add Patient</button>
            </div>
          </div>
        </div>
      </div>
    </div>



  </div>
</template>

<script>
import axios from 'axios';
import { useAuthStore } from '../stores/auth';

export default {
  name: 'XpplAppClinicTreatment',
  setup() {
    const authStore = useAuthStore();
    return { authStore };
  },

  data() {
    return {

      lkSex: ['Male', 'Female', 'LGBTQ'],
      search: '',
      contractForm: { row_index: '', contract_id: '', customer_id: null, contract_no: '', contract_appendix: '', signed_date: '', contract_quantity: '', contract_grade_id: null, contract_grade_gar: '', loading_place: '', delivery_place: '', contract_status: null, contract_remark: '' },


      codes: [],
      medicines: [],
      lkCompany: [],
      lkDepartment: [],
      lkPosition: [],
      lkDiagnosis: [],
      lkPatientType: [],
      lkMedicalType: [],
      lkHospital: [],
      lkTransfer: [],
      lkBloodGroup: [],
      lkMedicine: [],
      lkMedic: [],
      lkSection: [],
      lkInjPart: [],
      lkInjType: [],
      lkRelated: [],
      lkDept: [],


      lkComLao: [],
      lkDeptLao: [],
      lkPositLao: [],
      lkDiagnosisLao: [],
      lkPatientLao: [],
      lkMedicalLao: [],
      lkHospitalLao: [],
      lkTransferLao: [],
      lkBloodGLao: [],
      lkSectionLao: [],
      lkDoctorLao: [],

      patientForm: { patient_id: '', photo: '', photo_file: '', sex: 'Male', patient_name: '', company: null, department: null, position: null, employee_id: '', age: '', phone: '', blood_group: '', disease: '', drug_allergy: '', note: '' },
      treatmentFrom: { treatment_id: '', date_time: '', medical_type: null, injury_type: null, injury_part: null, work_related: null, temp_c: '', blood_press: '', puls: '', oxigen: '', weight: '', syndrome: '', diagnosis: null, patient_type: null, transfer: null, hospital: null, medic: null },
      medicationForm: { medication_id: '', medicine_id: '', qty: '', unit_eng: '' },
      medicationTemp: [],

    };
  },

  mounted() {

  },

  computed: {
    medicationDis() {
      if (this.medicationForm.medicine_id == null || this.medicationForm.qty == '' || this.medicationForm.unit_eng == '') {
        return 'disabled';
      } else {
        return '';
      }
    },

    unit() {
      if (this.medicationForm.medicine_id) {
        let item = this.medicines.find((e) => e.medicine_id == this.medicationForm.medicine_id);
        this.medicationForm.unit_eng = item.unit_eng;
      } else {
        this.medicationForm.unit_eng = '';
      }
    },

    addPatientDis() {
      let p = this.patientForm;
      let t = this.treatmentFrom;

      if (p.patient_name == '' || p.company == null || t.date_time == '' || t.medical_type == null || t.work_related == null || t.syndrome == '' || t.diagnosis == null || t.patient_type == null || t.medic == null || this.medicationTemp.length == 0) {
        return 'disabled'
      } else if (p.company == 'XPPL' && (p.department == '' || p.department == null)) {
        return 'disabled'
      } else if (t.medical_type == 'Accident' && (t.injury_type == '' || t.injury_type == null)) {
        return 'disabled'
      } else {
        return ''
      }




    },
  },

  methods: {
    async onLoad() {

      const position = await axios.get('api/employee/codes', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });

      const data = position.data.filter(e => e.category == 'Position')


      data.forEach(e => {
        this.lkPosition.push(e.code)
      });






    },

    async getMedicines() {
      const medicine = await axios.get('api/clinic/medicines', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      this.medicines = medicine.data;

      this.medicines.forEach(e => {
        this.lkMedicine.push({
          value: e.medicine_id,
          label: e.medicine_eng
        })
      });
    },

    async getDepartments() {
      const depts = await axios.get('api/employee/departments', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } });
      const departments = depts.data;

      let item = departments.filter((e) => e.company_id == 3);
      item.forEach((e) => {
        this.lkDept.push(e.dept_eng)
      });
    },

    newPatient() {
      this.patientForm = {};
      this.treatmentFrom = {};
      this.medicationForm = {};
      this.patientForm.sex = 'Male';

      const currentDate = new Date();
      const formattedDate = currentDate.toISOString();
      this.treatmentFrom.date_time = moment(currentDate).format('YYYY-MM-DD HH:mm');

      flatpickr('.flatpickr-single', {
        altInput: true,
        altFormat: 'd-m-Y H:i',
        enableTime: true,
        time_24hr: true,
        enableSeconds: false,
        minuteIncrement: 5,
        hourIncrement: 1,
        defaultDate: formattedDate,
        time_disabled: ["00:00"],
      });
      $('#patient-modal').modal('show');
    },

    addMedicationTemp() {
      let f = this.medicationForm;
      let item = this.medicationTemp.find((e) => e.medicine_id == f.medicine_id);

      if (item) {
        item.qty = item.qty + f.qty
      } else {
        let medicine = this.medicines.find((e) => e.medicine_id == f.medicine_id);
        this.medicationTemp.push({
          medicine_id: f.medicine_id,
          medicine: medicine.medicine_eng,
          qty: f.qty,
          unit_eng: f.unit_eng,
          note: 'new'
        })
      };

      f.medicine_id = '';
      f.qty = '';
      f.unit_eng = '';
    },

    delMedicationTemp(index) {
      this.medicationTemp.splice(index, 1);
    },

    addPatient() {
      let fd = new FormData();

      let fp = this.patientForm;
      fd.append('sex', fp.sex);
      fd.append('patient_name', fp.patient_name);
      fd.append('company', fp.company);
      fp.department ? fd.append('department', fp.department) : '';
      fp.position ? fd.append('position', fp.position) : '';
      fp.employee_id ? fd.append('employee_id', fp.employee_id) : '';
      fp.age ? fd.append('age', fp.age) : '';
      fp.blood_group ? fd.append('blood_group', fp.blood_group) : '';
      fp.phone ? fd.append('phone', fp.phone) : '';
      fp.disease ? fd.append('disease', fp.disease) : '';
      fp.drug_allergy ? fd.append('drug_allergy', fp.drug_allergy) : '';
      fp.note ? fd.append('note', fp.note) : '';
      fp.photo_file ? fd.append('photo', fp.photo_file) : '';

      let ft = this.treatmentFrom;
      fd.append('date_time', ft.date_time);
      fd.append('medical_type', ft.medical_type);
      fd.append('work_related', ft.work_related);
      fd.append('syndrome', ft.syndrome);
      fd.append('diagnosis', ft.diagnosis);
      fd.append('patient_type', ft.patient_type);
      fd.append('medic', ft.medic);
      ft.injury_type ? fd.append('injury_type', ft.injury_type) : '';
      ft.temp_c ? fd.append('temp_c', ft.temp_c) : '';
      ft.blood_press ? fd.append('blood_press', ft.blood_press) : '';
      ft.puls ? fd.append('puls', ft.puls) : '';
      ft.oxigen ? fd.append('oxigen', ft.oxigen) : '';
      ft.weight ? fd.append('weight', ft.weight) : '';
      ft.transfer ? fd.append('transfer', ft.transfer) : '';
      ft.hospital ? fd.append('hospital', ft.hospital) : '';
      ft.injury_part ? fd.append('injury_part', ft.injury_part.join(", ")) : '';

      for (let i = 0; i < this.medicationTemp.length; i++) {
        fd.append('medicine_id[' + i + ']', this.medicationTemp[i].medicine_id);
        fd.append('medicine[' + i + ']', this.medicationTemp[i].medicine);
        fd.append('qty[' + i + ']', this.medicationTemp[i].qty);
        fd.append('unit_eng[' + i + ']', this.medicationTemp[i].unit_eng);
      };

      axios.post('api/clinic/add-patient', fd, { headers: { 'Content-Type': 'multipart/form-data', Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {
        if (response.data.success) {

          $('#patient-modal').modal('hide');

          // toastr.success('Successfully!');
          // this.getContracts();
          // this.getOrders();
          // this.getFiles();
          // this.disableDropdown();

        } else {
          toastr.error(`${response.data.message}`);
        }

      }).catch((error) => {
        console.log(error);
      });







    },

    newPhoto() {
      this.$refs.photo.click();
    },

    selectPhoto() {
      let file = this.$refs.photo.files;

      this.patientForm.photo = file[0].name;
      this.patientForm.photo_file = file[0];

      console.log(file[0].name);
      console.log(file[0]);

      // for (let i = 0; i < file.length; i++) {
      //   let check = this.fileFilter.find((e) => e.file_name == file[i].name);
      //   if (!check) {
      //     this.fileFilter.push({
      //       file: file[i],
      //       file_name: file[i].name,
      //       file_type: this.store.fileType(file[i].name),
      //       size: (file[i].size / 1024).toFixed(0) + ' KB',
      //       note: 'new'
      //     });
      //   }
      // }
    },

    setfocus() {
      document.getElementById('medication-qty').focus();
    },

    getCodes() {
      axios.get('api/clinic/codes', { headers: { Authorization: 'Bearer ' + this.authStore.getToken } }).then((response) => {

        this.codes = response.data;

        let temp = [
          { category: 'Blood Group', valueCol: 'code', labelCol: 'code', lkName: 'lkBloodGroup' },
          { category: 'Medical Type', valueCol: 'code', labelCol: 'code', lkName: 'lkBloodGroup' },
          { category: 'Injury Type', valueCol: 'code', labelCol: 'code', lkName: 'lkBloodGroup' },
          { category: 'Injury Part', valueCol: 'code', labelCol: 'code', lkName: 'lkBloodGroup' },
          { category: 'Work Related', valueCol: 'code', labelCol: 'code', lkName: 'lkBloodGroup' },
          { category: 'Diagnosis', valueCol: 'code', labelCol: 'code', lkName: 'lkBloodGroup' },
          { category: 'Patient Type', valueCol: 'code', labelCol: 'code', lkName: 'lkBloodGroup' },
          { category: 'Transfer', valueCol: 'code', labelCol: 'code', lkName: 'lkBloodGroup' },
          { category: 'Hospital', valueCol: 'code', labelCol: 'code', lkName: 'lkBloodGroup' },
          { category: 'Medic', valueCol: 'code', labelCol: 'code', lkName: 'lkBloodGroup' },
        ];


        let data = [
          { cate: 'Company', col: 'code', name: 'lkCompany' },
          { cate: 'Diagnosis', col: 'code', name: 'lkDiagnosis' },
          { cate: 'Medical Type', col: 'code', name: 'lkMedicalType' },
          { cate: 'Patient Type', col: 'code', name: 'lkPatientType' },
          { cate: 'Hospital', col: 'code', name: 'lkHospital' },
          { cate: 'Transfer', col: 'code', name: 'lkTransfer' },
          { cate: 'Medic', col: 'code', name: 'lkMedic' },
          { cate: 'Section', col: 'code', name: 'lkSection' },
          { cate: 'Injury Part', col: 'code', name: 'lkInjPart' },
          { cate: 'Injury Type', col: 'descr_eng', name: 'lkInjType' },
          { cate: 'Work Related', col: 'code', name: 'lkRelated' },
          { cate: 'Blood Group', col: 'code', name: 'lkBloodGroup' },

          // { cate: 'Company', col: 'descr_lao', name: 'lkComLao' },
          // { cate: 'Department', col: 'descr_lao', name: 'lkDeptLao' },
          // { cate: 'Position', col: 'descr_lao', name: 'lkPositLao' },
          // { cate: 'Diagnosis', col: 'descr_lao', name: 'lkDiagnosisLao' },
          // { cate: 'Medical Type', col: 'descr_lao', name: 'lkMedicalLao' },
          // { cate: 'Patient Type', col: 'descr_lao', name: 'lkPatientLao' },
          // { cate: 'Hospital', col: 'descr_lao', name: 'lkHospitalLao' },
          // { cate: 'Transfer', col: 'descr_lao', name: 'lkTransferLao' },
          // { cate: 'Blood Group', col: 'descr_lao', name: 'lkBloodGLao' },
          // { cate: 'Section', col: 'descr_lao', name: 'lkSectionLao' },
          // { cate: 'Doctor', col: 'descr_lao', name: 'lkDoctorLao' },
        ];

        for (let e = 0; e < data.length; e++) {

          let category = data[e].cate;
          let colName = data[e].col;
          let lkName = data[e].name;

          let item = this.codes.filter((e) => e.category == [category]);
          for (let i = 0; i < item.length; i++) {
            this[lkName].push({
              value: item[i].code,
              label: item[i][colName]
            });
          };
        };




      }).catch((err) => {
        console.log(err);
      });
    }


  },

  created() {
    this.getCodes();
    this.getMedicines();
    this.getDepartments();
    this.onLoad();
  }
};
</script>