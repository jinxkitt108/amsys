<template>
  <v-container>
    <v-card>
      <v-card-text>
        <v-data-table :items="getAllClassLevels" :headers="headers" :search="search">
          <template v-slot:top>
            <v-toolbar flat>
              <v-toolbar-title>Class List</v-toolbar-title>
              <v-divider class="mx-4" inset vertical></v-divider>
              <v-text-field
                v-model="search"
                append-icon="mdi-magnify"
                label="Search message.."
                single-line
                hide-details
              ></v-text-field>
              <v-spacer></v-spacer>

              <!-- DIALOG ADD CLASS LEVELS -->
              <v-dialog v-model="dialog" max-width="500px">
                <template v-slot:activator="{ on }">
                  <v-btn color="primary" dark class="mb-2" v-on="on">
                    <v-icon left>mdi-account-multiple-plus</v-icon>Class
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title>
                    <span class="headline">Fill up Information</span>
                  </v-card-title>

                  <!-- Form Adding Class Level -->
                  <v-form @submit.prevent="saveNewClass">
                    <v-card-text>
                      <v-select
                        v-model="new_class.degree"
                        :items="getAllDegrees"
                        item-text="code"
                        label="Degree Course"
                        outlined
                        dense
                      ></v-select>
                      <div class="d-flex justify-space-around">
                        <v-select
                          @change="getClassCode"
                          v-model="new_class.year"
                          :items="['1', '2', '3', '4']"
                          label="Year"
                          class="mr-2"
                          outlined
                          dense
                        ></v-select>

                        <v-select
                          @change="getClassCode"
                          v-model="new_class.section"
                          :items="['A', 'B', 'C', 'D', 'E']"
                          label="Section"
                          class="mr-2"
                          outlined
                          dense
                        ></v-select>

                        <v-text-field
                          @change="getClassCode"
                          type="number"
                          v-model="new_class.no_of_students"
                          label="No. of Students"
                          outlined
                          dense
                        ></v-text-field>
                      </div>
                      <v-text-field
                        v-model="new_class.class_level_code"
                        label="Class Code"
                        filled
                        rounded
                        readonly
                        class="d-inline-flex"
                      ></v-text-field>
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

          <!-- Custom Column Fields -->
          <template v-slot:item.actions="{ item }">
            <v-chip dark icon small color="indigo" @click="openInfo(item)">
              <v-icon left>mdi-eye</v-icon>Info
            </v-chip>
          </template>
        </v-data-table>

        <!-- DIALOG INFO-->
        <v-dialog
          v-model="dialog_sched"
          fullscreen
          hide-overlay
          transition="dialog-bottom-transition"
        >
          <v-card>
            <v-toolbar dark color="primary">
              <v-btn icon dark @click="dialog_sched = false">
                <v-icon>mdi-close</v-icon>
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn text @click="dialog_sched = false">Close</v-btn>
            </v-toolbar>

            <v-card-title>
              <v-list-item>
                <v-list-item-content>
                  <v-list-item-title
                    class="headline font-weight-bold"
                  >{{getClassLevel.class_level_code}}</v-list-item-title>
                  <v-list-item-title class="subtitle-1">
                    No. of Students:
                    <span
                      class="ml-2 font-weight-bold"
                    >{{getClassLevel.no_of_students}}</span>
                  </v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-card-title>

            <v-card-text>
              <v-data-table :headers="headers_course" :search="search_course">
                <template v-slot:top>
                  <v-toolbar flat>
                    <v-toolbar-title>SUBJECT COURSES</v-toolbar-title>
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
                      <v-icon left>mdi-note-plus</v-icon>Add Subject Course
                    </v-btn>

                    <v-dialog v-model="dialog_course" max-width="500px">
                      <v-card>
                        <v-card-title class="subtitle-1">Fill up details</v-card-title>
                        <v-card-text>
                          <v-form>
                            <v-text-field></v-text-field>
                            <v-text-field></v-text-field>
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
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  mounted() {
    console.log("Component mounted.");
  },

  created() {
    this.fetchAllDegrees();
    this.fetchAllClassLevels();
  },

  watch: {
    dialog(val) {
      !val && this.new_class.reset();
    }
  },

  data() {
    return {
      dialog: false,
      dialog_sched: false,
      dialog_course: false,
      loading: false,
      search_course: null,

      new_class: new Form({
        class_level_code: "",
        degree: "",
        year: "",
        section: "",
        no_of_students: ""
      }),

      new_course: new Form({
        class_level_id: "",
        course_code: "",
        course_description: "",
        units: "",
        lec: "",
        lab: "",
        total: ""
      }),

      //Data Table
      search: null,
      headers: [
        { text: "Class Code", filterable: true, value: "class_level_code" },
        { text: "Degree", filterable: true, value: "degree" },
        { text: "Year Level", value: "year", filterable: true },
        { text: "Section", value: "section", filterable: true },
        { text: "No. of Students", filterable: true, value: "no_of_students" },
        { text: "Actions", sortable: false, value: "actions" }
      ],

      headers_course: [
        { text: "COURSE CODE", filterable: true, value: "course_code" },
        { text: "DESCRIPTION", filterable: true, value: "course_description" },
        { text: "UNITS", sortable: false, value: "no_of_units" },
        { text: "LEC", sortable: false, value: "lec" },
        { text: "LAB", sortable: false, value: "lab" },
        { text: "TOTAL", sortable: false, value: "total" },
        { text: "Actions", sortable: false, value: "actions" }
      ]
    };
  },

  computed: {
    ...mapGetters([
      "getAllColleges",
      "getAllDegrees",
      "getAllClassLevels",
      "getClassLevel"
    ])
  },

  methods: {
    ...mapActions([
      "fetchAllDegrees",
      "fetchAllClassLevels",
      "addClassLevel",
      "fetchClassLevel"
    ]),

    openInfo(item) {
      this.fetchClassLevel(item).then(() => {
        this.dialog_sched = true;
      });
    },

    getClassCode() {
      let code =
        this.new_class.degree +
        " " +
        this.new_class.year +
        this.new_class.section;

      this.new_class.class_level_code = code;
    },

    saveNewClass() {
      this.addClassLevel(this.new_class).then(() => {
        this.dialog = false;
        this.new_class.reset();
        Toast.fire({
          icon: "success",
          title: "A new class level added!"
        });
      });
    },

    close() {
      this.dialog = false;
      this.new_class.reset();
    }
  }
};
</script>
