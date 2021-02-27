<template>
  <v-container>
    <v-data-table :items="getAllInstructors" :headers="headers" :search="search">
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Faculty List</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search here.."
            single-line
            hide-details
          ></v-text-field>
          <v-spacer></v-spacer>

          <!-- DIALOG INSTRUCTOR -->
          <v-dialog v-model="dialog" max-width="500">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2" v-on="on">
                <v-icon left>mdi-account-plus</v-icon>Instructor
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">Fill up Information</span>
              </v-card-title>

              <v-form @submit.prevent="saveNewInstructor">
                <v-card-text>
                  <v-row class="d-flex px-5">
                    <v-text-field
                      v-model="new_instructor.name"
                      label="Name"
                      dense
                      class="d-inline-flex mr-3"
                    ></v-text-field>
                    <v-text-field
                      v-model="new_instructor.employee_id"
                      label="Employee ID"
                      dense
                      class="d-inline-flex mr-3"
                    ></v-text-field>
                  </v-row>
                  <v-row dense class="d-flex flex-row px-5">
                    <v-select
                      v-model="new_instructor.gender"
                      :items="['Male', 'Female']"
                      label="Gender"
                      class="mr-3"
                      dense
                    ></v-select>
                    <v-select
                      v-model="new_instructor.status"
                      :items="['Single', 'Married', 'Widow', 'Widower', 'Separated']"
                      label="Status"
                      class="mr-3"
                      dense
                    ></v-select>
                  </v-row>

                  <v-select
                    v-model="new_instructor.work_status"
                    :items="['Regular', 'Temporary', 'Full time (Part Time)', 'Part Time (Part Time)']"
                    label="Work Status"
                    filled
                    dense
                  ></v-select>
                  <v-textarea
                    v-model="new_instructor.remarks"
                    label="Remarks"
                    rows="3"
                    outlined
                    dense
                  ></v-textarea>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn @click="close">Cancel</v-btn>
                  <v-btn
                    :loading="loading"
                    :disabled="loading"
                    type="submit"
                    color="blue darken-1"
                    dark
                  >Save</v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>

      <!-- TABLE COLUMN SLOTS -->
      <template v-slot:item.actions="{ item }">
        <v-btn fab x-small @click="viewQrcode(item)">
          <v-icon>mdi-qrcode</v-icon>
        </v-btn>
        <v-btn fab x-small dark color="blue" @click="openInfo(item)">
          <v-icon>mdi-eye</v-icon>
        </v-btn>
      </template>
    </v-data-table>

    <!-- DIALOG INFO-->
    <v-dialog
      v-model="dialog_profile"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
    >
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog_profile = false">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar>

        <v-card-title>
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="headline font-weight-bold">{{getInstructor.name}}</v-list-item-title>
              <v-list-item-title class="subtitle-1">{{getInstructor.work_status}}</v-list-item-title>
              <v-list-item-subtitle class="caption">{{getInstructor.remarks}}</v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-card-title>

        <v-card-text>
          <v-data-table :headers="headers_course" :search="search_course">
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title>HANDLED COURSES</v-toolbar-title>
                <v-divider class="mx-4" inset vertical></v-divider>
                <v-text-field
                  v-model="search_course"
                  append-icon="mdi-magnify"
                  label="Search here.."
                  single-line
                  hide-details
                ></v-text-field>
                <v-spacer></v-spacer>
                <v-btn color="primary" dark class="mb-2" @click="dialog_course = true">
                  <v-icon left>mdi-note-plus</v-icon>Load Course
                </v-btn>

                <!-- DIALOG ADD COURSE -->
                <v-dialog v-model="dialog_course" max-width="500px">
                  <v-card>
                    <v-card-title class="subtitle-1">Fill up details</v-card-title>
                    <v-card-text>
                      <v-form>
                        <v-text-field></v-text-field>
                      </v-form>
                    </v-card-text>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
          </v-data-table>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- DIALOG View QrCode -->
    <v-dialog v-model="dialog_qrcode" max-width="500px">
      <v-card>
        <v-card-title v-if="dialog_qrcode">
          <v-list-item>
            <v-list-item-content>
              <v-list-item-title class="font-weight-bold">{{getInstructor.name}}</v-list-item-title>
              <v-list-item-title>Employee Id: {{getInstructor.employee.employee_id}}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-card-title>

        <v-card-text class="text-center">
          <qrcode
            v-if="dialog_qrcode"
            :value="getInstructor.employee.employee_id"
            :options="{ width: 300}"
          ></qrcode>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- OVERLAY LOADER -->
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64" width="20"></v-progress-circular>
    </v-overlay>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  created() {
    this.fetchAllInstructors();
  },

  data() {
    return {
      loading: false,
      overlay: false,
      dialog: false,
      dialog_profile: false,
      dialog_course: false,
      dialog_qrcode: false,

      //Data Tables
      search: null,
      headers: [
        { text: "Name", filterable: true, value: "name" },
        { text: "Gender", filterable: true, value: "gender" },
        { text: "Status", value: "status", filterable: true },
        { text: "Work Status", filterable: true, value: "work_status" },
        { text: "Remarks", sortable: false, value: "remarks" },
        { text: "Actions", sortable: false, value: "actions" }
      ],

      search_course: null,
      headers_course: [
        { text: "COURSE CODE", filterable: true, value: "course_code" },
        { text: "DESCRIPTION", filterable: true, value: "course_description" },
        {
          text: "COURSE/YEAR & SECTION",
          value: "year_and_section",
          filterable: true
        },
        { text: "NO. OF STUDENTS", filterable: true, value: "no_of_students" },
        { text: "NO. OF UNITS", sortable: false, value: "no_of_units" },
        { text: "LEC", sortable: false, value: "lec" },
        { text: "LAB", sortable: false, value: "lab" },
        { text: "TOTAL", sortable: false, value: "total" },
        { text: "Actions", sortable: false, value: "actions" }
      ],

      //FORM INSTRUCTOR
      new_instructor: new Form({
        id: "",
        employee_id: "",
        name: "",
        gender: "",
        status: "",
        work_status: "",
        remarks: ""
      }),

      //FORM COURSE
      load_course: new Form({
        id: "",
        course_code: "",
        course_description: "",
        year_and_section: "",
        no_of_students: "",
        no_of_units: "",
        lec: "",
        lab: "",
        total: ""
      })
    };
  },

  computed: {
    ...mapGetters(["getAllInstructors", "getInstructor"])
  },

  methods: {
    ...mapActions(["addInstructor", "fetchAllInstructors", "fetchInstructor"]),

    openInfo(item) {
      this.fetchInstructor(item.id);
      this.dialog_profile = true;
    },

    viewQrcode(item) {
      this.fetchInstructor(item.id).then(() => {
        this.dialog_qrcode = true;
      });
    },

    saveNewInstructor() {
      this.loading = true;
      this.addInstructor(this.new_instructor).then(() => {
        this.new_instructor.reset();
        this.loading = false;
        this.close();
      });
      Toast.fire({
        icon: "success",
        title: "Added successfully"
      });
    },

    close() {
      this.dialog = false;
    }
  }
};
</script>
