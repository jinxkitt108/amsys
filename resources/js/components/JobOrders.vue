<template>
  <v-container>
    <v-data-table :items="getAllStaffs" :headers="headers" :search="search">
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Staff List</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search message.."
            single-line
            hide-details
          ></v-text-field>
          <v-spacer></v-spacer>

          <!-- DIALOG STAFF -->
          <v-dialog v-model="dialog" max-width="500px">
            <template v-slot:activator="{ on }">
              <v-btn color="primary" dark class="mb-2" v-on="on">
                <v-icon left>mdi-account-plus</v-icon>Staff
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">Fill up Information</span>
              </v-card-title>

              <v-form @submit.prevent="saveNewStaff">
                <v-card-text>
                  <v-row class="d-flex px-5">
                    <v-text-field
                      v-model="new_staff.name"
                      label="Name"
                      dense
                      class="d-inline-flex mr-3"
                    ></v-text-field>
                    <v-text-field
                      v-model="new_staff.employee_id"
                      label="Employee ID"
                      dense
                      class="d-inline-flex mr-3"
                    ></v-text-field>
                  </v-row>
                  <v-row dense class="d-flex flex-row px-5">
                    <v-select
                      v-model="new_staff.status"
                      :items="['Single', 'Married', 'Widow', 'Widower', 'Separated']"
                      label="Status"
                      class="mr-5"
                      outlined
                      style="width: 100px"
                      dense
                    ></v-select>
                    <v-select
                      v-model="new_staff.gender"
                      :items="['Male', 'Female']"
                      label="Gender"
                      outlined
                      class="mr-3"
                      style="width: 100px"
                      dense
                    ></v-select>
                  </v-row>

                  <v-autocomplete
                    v-model="new_staff.position_title"
                    :items="positions"
                    :menu-props="{disableKeys: false, maxHeight: 200}"
                    dense
                    solo
                    label="Position Title"
                  ></v-autocomplete>
                  <v-textarea v-model="new_staff.remarks" label="Remarks" rows="3" outlined dense></v-textarea>
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
    </v-data-table>

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
    this.fetchAllStaffs();
  },

  data() {
    return {
      loading: false,
      overlay: false,
      dialog: false,

      positions: [
        "Maintenance Staff",
        "Watchman",
        "Scholarship Coordinator",
        "Utility Staff",
        "Guidance Associate",
        "QA Clerk",
        "Registrar Office Staff",
        "Utility Staff",
        "Cash Clerk",
        "Graduate School Office Staff",
        "OSSA Secretary",
        "Assessment Office Staff",
        "Research & Extension Assistant",
        "School Doctor",
        "Admin Staff",
        "Clinic Staff",
        "Supply Staff",
        "Utility Staff Staff",
        "MIS Staff",
        "HR Clerk",
        "Library Clerk",
        "Utility Staff",
        "CBM Staff",
        "Registrar Office Staff",
        "Driver",
        "School Dentist",
        "Assessment Office Staff"
      ],

      //Data Table
      search: null,
      headers: [
        { text: "Name", filterable: true, value: "name" },
        { text: "Gender", filterable: true, value: "gender" },
        { text: "Status", value: "status", filterable: true },
        { text: "Position", filterable: true, value: "position_title" },
        { text: "Remarks", sortable: false, value: "remarks" },
        { text: "Actions", sortable: false, value: "actions" }
      ],

      new_staff: new Form({
        id: "",
        employee_id: "",
        name: "",
        gender: "",
        status: "",
        position_title: "",
        remarks: ""
      })
    };
  },

  computed: {
    ...mapGetters(["getAllStaffs"])
  },

  methods: {
    ...mapActions(["addStaff", "fetchAllStaffs"]),

    saveNewStaff() {
      this.loading = true;
      this.addStaff(this.new_staff).then(() => {
        this.new_staff.reset();
        this.loading = false;
        this.close();

        Toast.fire({
          icon: "success",
          title: "Added successfully"
        });
      });
    },

    close() {
      this.dialog = false;
    }
  }
};
</script>
