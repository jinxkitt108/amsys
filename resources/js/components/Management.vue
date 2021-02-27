<template>
  <v-container>
    <v-card flat>
      <v-data-table
        :headers="headers_college"
        :items="getAllColleges"
        show-expand
        single-expand
        hide-default-footer
      >
        <!-- Table Top Label -->
        <template v-slot:top>
          <v-toolbar flat color="white">
            <v-toolbar-title>COLLEGES</v-toolbar-title>
            <v-divider class="mx-4" inset vertical></v-divider>
            <v-spacer></v-spacer>

            <v-dialog v-model="dialog_add_college" max-width="500px">
              <template v-slot:activator="{ on }">
                <v-btn color="primary" dark class="mb-2" v-on="on">
                  <v-icon left>mdi-plus</v-icon>College
                </v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="headline">New College</span>
                  <v-spacer></v-spacer>
                  <v-btn color="blue darken-1" text @click="close">Cancel</v-btn>
                  <v-btn color="blue darken-1" text @click="saveNewCollege">Save</v-btn>
                </v-card-title>

                <v-card-text>
                  <v-text-field
                    v-model="new_college.code"
                    outlined
                    dense
                    label="College Code"
                    hint="Ex. CCS, CTE, CBM, etc."
                    class="d-inline-flex"
                  ></v-text-field>
                  <v-text-field
                    v-model="new_college.description"
                    outlined
                    dense
                    label="College Description"
                  ></v-text-field>
                  <v-text-field
                    v-model="new_college.color_code"
                    filled
                    readonly
                    rounded
                    dense
                    label="Color Code"
                    class="d-inline-flex"
                  ></v-text-field>
                  <v-color-picker
                    v-model="new_college.color_code"
                    class="ma-2"
                    show-swatches
                    hide-inputs
                    hide-canvas
                  ></v-color-picker>
                </v-card-text>
              </v-card>
            </v-dialog>
          </v-toolbar>
        </template>

        <!-- Expanded Items COLLEGE TABLE -->
        <template v-slot:expanded-item="{ headers, item }">
          <td :colspan="headers.length">
            <v-list-item v-for="degree in item.degrees" :key="degree.id">
              <v-list-item-content>
                <v-list-item-title
                  class="font-weight-bold"
                >{{degree.description + ' '}}({{degree.code}})</v-list-item-title>
              </v-list-item-content>
              <v-btn small color="primary" @click="openAddCourses(degree)" outlined>
                <v-icon left>mdi-plus</v-icon>Courses
              </v-btn>
            </v-list-item>
          </td>
        </template>

        <!-- Table Content for College -->
        <template v-slot:item.color_code="{item}">
          <v-chip :color="item.color_code" dark>{{item.color_code}}</v-chip>
        </template>
        <template v-slot:item.no_of_degrees="{item}">{{item.no_of_degrees}}</template>
        <template v-slot:item.actions="{item}">
          <v-btn icon color="green" @click="openAddingDegree(item)">
            <v-icon>mdi-plus</v-icon>
          </v-btn>
        </template>
      </v-data-table>
    </v-card>

    <v-dialog v-model="dialog_add_course" fullscreen>
      <v-toolbar dark flat color="primary">
        <v-btn @click="close" icon>
          <v-icon>mdi-close</v-icon>
        </v-btn>
        <v-toolbar-title class="headline">{{getDegree.description}} ({{getDegree.code}})</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn @click="close" text>Close</v-btn>
      </v-toolbar>
      <v-card>
        <v-card-text>
          <v-row>
            <v-col sm="12" md="4">
              <h1 class="subtitle-1 font-weight-bold">Add Subject Course</h1>
              <v-select
                v-model="semester"
                label="Semester"
                :items="['First Semester', 'Second Semester']"
                outlined
                dense
              ></v-select>
              <v-select
                v-model="year_level"
                label="Year Level"
                :items="['1', '2', '3', '4']"
                outlined
                dense
              ></v-select>
              <v-flex class="text-center">
                <v-text-field
                  class="d-inline-flex"
                  v-model="new_course.course_code"
                  outlined
                  dense
                  label="Course Code"
                  hint="Ex. Math 1, Eng 1, SocSci 1, etc."
                  persistent-hint
                ></v-text-field>
              </v-flex>
              <v-text-field
                v-model="new_course.course_description"
                outlined
                dense
                label="Description"
              ></v-text-field>
              <v-flex class="d-flex">
                <v-text-field
                  @change="getTotal"
                  type="number"
                  v-model="new_course.units"
                  outlined
                  hide-details
                  dense
                  label="Units"
                ></v-text-field>
                <v-text-field
                  @change="getTotal"
                  type="number"
                  v-model="new_course.lec"
                  outlined
                  hide-details
                  dense
                  label="LEC"
                ></v-text-field>
                <v-text-field
                  @change="getTotal"
                  type="number"
                  v-model="new_course.lab"
                  outlined
                  hide-details
                  dense
                  label="LAB"
                ></v-text-field>
              </v-flex>
              <div class="text-center mt-3 mb-5">
                <v-text-field
                  class="d-inline-flex"
                  type="number"
                  v-model="new_course.total"
                  readonly
                  hide-details
                  outlined
                  rounded
                  dense
                  label="total"
                ></v-text-field>
              </div>
              <v-btn dark color="blue darken-1" block @click="saveNewCourse">Save</v-btn>
            </v-col>

            <v-col sm="12" md="8">
              <v-card>
                <v-card-title>Subject Courses</v-card-title>
                <v-card-text>
                  <v-data-table :items="getDegree.courses" :headers="headers_courses"></v-data-table>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog v-model="dialog_add_degree" max-width="600px">
      <v-card>
        <v-card-title>
          <span class="headline">New Degree for {{new_degree.college_code}}</span>
        </v-card-title>
        <v-card-text>
          <v-text-field
            v-model="new_degree.code"
            outlined
            dense
            label="Degree Code"
            hint="Ex. BSIT, BSHM, BSED (Math)"
            persistent-hint
          ></v-text-field>
          <v-text-field v-model="new_degree.description" outlined dense label="Desctiption"></v-text-field>
          <v-text-field
            v-model="new_degree.major"
            outlined
            dense
            label="Major"
            hint="Leave if not available"
            persistent-hint
          ></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close">Close</v-btn>
          <v-btn color="blue darken-1" text @click="saveNewDegree">Save</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  mounted() {
    console.log("Component mounted.");
  },

  created() {
    this.fetchAllColleges();
  },

  watch: {
    dialog_add_college(val) {
      !val && this.new_college.reset();
    },

    dialog_add_degree(val) {
      !val && this.new_degree.reset();
    },

    dialog_add_course(val) {
      !val && this.new_course.reset();
    }
  },

  data() {
    return {
      loading: false,
      overlay: false,
      dialog_add_college: false,
      dialog_add_degree: false,
      dialog_college_info: false,
      dialog_add_course: false,

      //Data Table
      search: null,

      headers_college: [
        { text: "College Code", filterable: true, value: "code" },
        { text: "Description", filterable: true, value: "description" },
        { text: "Color", filterable: true, value: "color_code" },
        {
          text: "No of Degrees",
          align: "center",
          filterable: true,
          value: "no_of_degrees"
        },
        { text: "Actions", filterable: true, value: "actions" },
        { text: "", value: "data-table-expand" }
      ],

      headers_courses: [
        { text: "YEAR LEVEL", filterable: true, value: "year_level" },
        { text: "SEMESTER", filterable: true, value: "semester" },
        { text: "COURSE CODE", filterable: true, value: "course_code" },
        { text: "DESCRIPTION", filterable: true, value: "course_description" },
        { text: "UNITS", sortable: false, value: "no_of_units" },
        { text: "LEC", sortable: false, value: "lec" },
        { text: "LAB", sortable: false, value: "lab" },
        { text: "TOTAL", sortable: false, value: "total" },
        { text: "Actions", sortable: false, value: "actions" }
      ],

      new_college: new Form({
        id: "",
        code: "",
        description: "",
        color_code: ""
      }),

      new_degree: new Form({
        id: "",
        code: "",
        description: "",
        major: "",
        college_code: "",
        college_id: ""
      }),

      //STATIC INPUTS
      semester: "",
      year_level: "",

      new_course: new Form({
        degree_id: "",
        semester: "",
        year_level: "",
        course_code: "",
        course_description: "",
        units: 0,
        lec: 0,
        lab: 0,
        total: 0
      })
    };
  },

  computed: {
    ...mapGetters(["getAllColleges", "getDegree"])
  },

  methods: {
    ...mapActions([
      "addCollege",
      "addDegree",
      "fetchAllColleges",
      "fetchDegree",
      "deleteDegree",
      "addCourse"
    ]),

    saveNewCourse() {
      this.new_course.year_level = this.year_level;
      this.new_course.semester = this.semester;
      this.addCourse(this.new_course).then(() => {
        this.new_course.reset();
        this.new_course.year_level = this.year_level;
        this.new_course.semester = this.semester;
        Toast.fire({
          icon: "success",
          title: "New subject course added!"
        });
      });
    },

    getTotal() {
      this.new_course.total =
        Number(this.new_course.units) +
        Number(this.new_course.lec) +
        Number(this.new_course.lab);
    },

    openAddCourses(degree) {
      this.fetchDegree(degree.id);
      this.new_course.degree_id = degree.id;
      this.new_course.degree_code = degree.code;
      this.dialog_add_course = true;
    },

    close() {
      this.dialog_add_college = false;
      this.dialog_add_degree = false;
      this.dialog_add_course = false;
      this.new_college.reset();
      this.new_degree.reset();
      this.new_course.reset();
    },

    requestDelete(degree) {
      this.deleteDegree(degree).then(() => {
        Toast.fire({
          icon: "warning",
          title: "A degree is removed!"
        });
      });
    },

    openAddingDegree(item) {
      this.dialog_add_degree = true;
      this.new_degree.college_code = item.code;
      this.new_degree.college_id = item.id;
    },

    saveNewCollege() {
      this.addCollege(this.new_college).then(() => {
        this.close();
        Toast.fire({
          icon: "success",
          title: "College added successfully"
        });
      });
    },

    saveNewDegree() {
      this.addDegree(this.new_degree).then(() => {
        this.close();
        Toast.fire({
          icon: "success",
          title: "Degree added successfully"
        });
      });
    }
  }
};
</script>
