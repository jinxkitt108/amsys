<style lang="scss" scoped>
.attendace-card {
  background: rgb(9, 4, 99);
  background: linear-gradient(
    135deg,
    rgba(9, 4, 99, 1) 42%,
    rgba(29, 29, 133, 1) 61%,
    rgba(70, 132, 244, 1) 100%
  );
}

.employee-card {
  background: rgb(139, 8, 34);
  background: linear-gradient(
    135deg,
    rgba(139, 8, 34, 1) 44%,
    rgba(213, 11, 60, 1) 76%,
    rgba(222, 39, 75, 1) 100%
  );
}

.faculty-card {
  background: rgb(4, 88, 98);
  background: linear-gradient(
    135deg,
    rgba(4, 88, 98, 1) 44%,
    rgba(25, 129, 148, 1) 76%,
    rgba(85, 196, 241, 1) 100%
  );
}

.job-order-card {
  background: rgb(179, 52, 6);
  background: linear-gradient(
    135deg,
    rgba(179, 52, 6, 1) 44%,
    rgba(190, 123, 6, 1) 76%,
    rgba(235, 124, 12, 1) 100%
  );
}
</style>
<template>
  <v-container>
    <v-toolbar dense flat>
      <v-toolbar-title class="subtitle-1 font-weight-bold">OVERVIEW</v-toolbar-title>
    </v-toolbar>

    <v-row dense class="d-flex">
      <v-card dark width="150" height="65" class="mx-2 my-1 attendace-card">
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>
              <v-icon size="30" left>mdi-alpha-a-circle</v-icon>
              <span class="title">{{getAllAttendance.length}}</span>
            </v-list-item-title>
            <v-list-item-title class="subtitle-2 font-weight-bold">Attendance</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-card>

      <v-card dark width="150" height="65" class="mx-2 my-1 employee-card">
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>
              <v-icon size="30" left>mdi-alpha-e-circle</v-icon>
              <span class="title">{{getAllEmployee.length}}</span>
            </v-list-item-title>
            <v-list-item-title class="subtitle-2 font-weight-bold">Total Employee</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-card>

      <v-card dark color="teal" width="150" height="65" class="mx-2 my-1 faculty-card">
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>
              <v-icon size="30" left>mdi-account-multiple</v-icon>
              <span class="title">{{getAllInstructors.length}}</span>
            </v-list-item-title>
            <v-list-item-title class="subtitle-2 font-weight-bold">Faculty</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-card>

      <v-card dark color="orange darken-3" width="150" height="65" class="mx-2 my-1 job-order-card">
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title>
              <v-icon size="30" left>mdi-account-multiple</v-icon>
              <span class="title">{{getAllStaffs.length}}</span>
            </v-list-item-title>
            <v-list-item-title class="subtitle-2 font-weight-bold">Job Order Staff</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-card>
    </v-row>

    <v-row class="mt-3" dense>
      <v-col cols="12">
        <v-card flat>
          <v-card-text>
            <v-data-table
              :items="getAllAttendance"
              :headers="headers_attendance"
              :search="search"
              :items-per-page="5"
            >
              <template v-slot:top>
                <v-toolbar dense flat>
                  <v-toolbar-title class="subtitle-1 font-weight-bold">ATTENDANCE</v-toolbar-title>
                  <v-spacer></v-spacer>
                  <v-text-field
                    v-model="search"
                    prepend-inner-icon="mdi-magnify"
                    label="Search"
                    hide-details
                    dense
                    solo
                    rounded
                  ></v-text-field>
                </v-toolbar>
              </template>

              <template v-slot:item.in="{ item }">{{item.in | timeLong}}</template>
              <template v-slot:item.out="{ item }">
                <span v-if="item.out">{{item.out | timeLong}}</span>
              </template>
              <template v-slot:item.status="{ item }">
                <v-tooltip v-if="item.status" bottom>
                  <template v-slot:activator="{ on }">
                    <span v-on="on" class="subtitle-2 font-weight-bold red--text">LATE</span>
                  </template>
                  <span>{{item.status}}</span>
                </v-tooltip>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  created() {
    this.fetchAllInstructors();
    this.fetchAllStaffs();
    this.fetchAllAttendance();
    this.fetchAllEmployee();
  },

  computed: {
    ...mapGetters([
      "getAllInstructors",
      "getAllStaffs",
      "getAllAttendance",
      "getAllEmployee"
    ])
  },

  data() {
    return {
      search: null,
      headers_attendance: [
        { text: "Id", value: "employee_id" },
        { text: "Name", value: "name" },
        { text: "Position", value: "position" },
        { text: "Time-In", value: "in" },
        { text: "Time-Out", value: "out" },
        { text: "Status", value: "status" },
        { text: "Total Hours", value: "hours" }
      ]
    };
  },

  methods: {
    ...mapActions([
      "fetchAllInstructors",
      "fetchAllStaffs",
      "fetchAllAttendance",
      "fetchAllEmployee"
    ])
  }
};
</script>
