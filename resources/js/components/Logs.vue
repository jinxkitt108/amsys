<template>
  <v-container>
    <v-toolbar dense flat>
      <v-toolbar-title class="font-weight-bold">Attendance Logs</v-toolbar-title>
    </v-toolbar>

    <!-- Date Picker -->
    <v-menu v-model="menu_date" :close-on-content-click="false" class="mt-2">
      <template v-slot:activator="{ on }">
        <v-text-field
          :value="computedDate"
          clearable
          label="Log's Date"
          readonly
          prepend-icon="mdi-calendar"
          style="width: 300px"
          dense
          rounded
          outlined
          v-on="on"
        ></v-text-field>
      </template>
      <v-date-picker v-model="dateSet" @change="setLogDate" scrollable></v-date-picker>
    </v-menu>

    <v-card flat>
      <v-card-text>
        <span class="subtitle-1">{{date}}</span>
        <div
          v-for="log in getLogs"
          :key="log.id"
          class="border-bottom caption"
          style="max-width: 450px"
        >
          <span class="mr-4">{{log.created_at | timeShort}}</span>
          <span class="font-weight-bold">{{log.content.employee.name}}</span>
          <span>{{' has '+ log.action}}</span>
        </div>
        <p v-if="!getLogs.length" class="subtitle-2 mt-2 font-italic">No records available.</p>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  mounted() {
    console.log("Component mounted.");
  },

  created() {
    this.fetchLogs();
  },

  computed: {
    ...mapGetters(["getLogs"]),
    computedDate() {
      return this.dateSet
        ? moment(this.dateSet).format("dddd, MMMM D YYYY")
        : "";
    }
  },

  data() {
    return {
      menu_date: false,
      dateSet: "",
      date: "Today"
    };
  },

  methods: {
    ...mapActions(["fetchLogs", "fetchLogSet"]),
    setLogDate() {
      this.menu_date = false;
      this.date = moment(this.dateSet).format("dddd, MMMM D YYYY");
      this.fetchLogSet(this.dateSet);
    }
  }
};
</script>
