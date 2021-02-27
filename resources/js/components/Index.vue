<template>
  <v-app>
    <v-app-bar app dark color="indigo">
      <v-toolbar-title>amsys</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn text href="/home" class="text-decoration-none">
        <v-icon left>mdi-cogs</v-icon>Settings
      </v-btn>
    </v-app-bar>

    <v-content>
      <v-card width="450" class="mx-auto mt-5 pt-8">
        <v-card-title class="headline justify-md-center">ATTENDANCE LOG</v-card-title>
        <div class="text-center">
          <vue-clock />
          <p class="pa-2 title font-weight-bold">{{new Date | dayDate}} {{dayDate}}</p>
        </div>
        <v-card-text>
          <v-flex class="text-center">
            <v-btn @click="scannerOpen(false)" dark color="blue" x-large class="mr-3">Time In</v-btn>
            <v-btn @click="scannerOpen(true)" dark outlined color="black" x-large>Time Out</v-btn>
          </v-flex>
        </v-card-text>
      </v-card>

      <!-- Scanner Overlay -->
      <v-overlay :dark="false" :value="overlay_scanner">
        <v-card flat tile width="450">
          <v-card-text>
            <div class="camera">
              <qrcode-stream @decode="onDecode"></qrcode-stream>
            </div>
            <div v-if="code" class="text-center mt-3">
              <p class="subtitle-1 font-weight-bold">Employee ID: {{code}}</p>
            </div>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn dark color="red" @click="overlay_scanner = false">Close</v-btn>
          </v-card-actions>
        </v-card>
      </v-overlay>
    </v-content>

    <v-footer app dark>
      <span>&copy; 2019</span>
    </v-footer>
  </v-app>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      time_out: false,
      overlay_scanner: false,
      code: "",
      new_attendance: new Form({
        employee_id: "",
        time_out: null
      })
    };
  },

  computed: {
    dayDate() {
      let d = new Date();
      var weekday = new Array(7);
      weekday[0] = "Sunday";
      weekday[1] = "Monday";
      weekday[2] = "Tuesday";
      weekday[3] = "Wednesday";
      weekday[4] = "Thursday";
      weekday[5] = "Friday";
      weekday[6] = "Saturday";
      return weekday[d.getDay()];
    }
  },

  methods: {
    ...mapActions(["addAttendance"]),

    scannerOpen(action) {
      console.log(action);
      this.new_attendance.time_out = action;
      this.overlay_scanner = true;
    },

    onDecode(decodedString) {
      this.code = decodedString;
      this.new_attendance.employee_id = decodedString;
      this.addAttendance(this.new_attendance).then(() => {
        this.overlay_scanner = false;
        this.code = null;
      });
    }
  }
};
</script>
