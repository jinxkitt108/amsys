<style lang="scss" scoped>
.v-list-item {
  text-decoration: none;
}
</style>

<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" dense app clipped>
      <v-list>
        <v-list-item class="px-2">
          <v-list-item-avatar>
            <img src="app_images/avatars/officer.png" />
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title class="subtitle-2 font-weight-bold">{{getAuthUser.name}}</v-list-item-title>
            <div class="overline">{{getAuthUser.type}}</div>
            <v-list-item-subtitle>Logged In</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list dense nav>
        <v-list-item to="/home" class="text-decoration-none">
          <v-list-item-icon>
            <v-icon>mdi-home</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Home</v-list-item-title>
        </v-list-item>
        <v-list-item to="/" class="text-decoration-none">
          <v-list-item-icon>
            <v-icon>mdi-clock</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Time In/Out</v-list-item-title>
        </v-list-item>

        <v-list-item to="/logs" class="text-decoration-none">
          <v-list-item-icon>
            <v-icon>mdi-note</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Logs</v-list-item-title>
        </v-list-item>

        <v-list-item to="/management" class="text-decoration-none">
          <v-list-item-icon>
            <v-icon>mdi-tools</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Management</v-list-item-title>
        </v-list-item>

        <v-list-item to="/instructor" class="text-decoration-none">
          <v-list-item-icon>
            <v-icon>mdi-account-group</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Instructors</v-list-item-title>
        </v-list-item>

        <v-list-item to="/job_orders" class="text-decoration-none">
          <v-list-item-icon>
            <v-icon>mdi-sitemap</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Job Orders</v-list-item-title>
        </v-list-item>

        <v-list-item class="text-decoration-none">
          <v-list-item-icon>
            <v-icon>mdi-book-multiple</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Subject Course</v-list-item-title>
        </v-list-item>

        <v-list-item to="/class" class="text-decoration-none">
          <v-list-item-icon>
            <v-icon>mdi-account-box-multiple</v-icon>
          </v-list-item-icon>
          <v-list-item-title>Class</v-list-item-title>
        </v-list-item>

        <v-list-item @click="logout">
          <v-list-item-icon>
            <v-icon color="red">mdi-power-off</v-icon>
          </v-list-item-icon>
          <v-list-item-title class="font-weight-bold red--text">Log Out</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar app clipped-left dark color="indigo">
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title>amsys</v-toolbar-title>
    </v-app-bar>

    <!-- Sizes your content based upon application components -->
    <v-content>
      <!-- If using vue-router -->
      <router-view></router-view>
    </v-content>

    <v-footer app>
      <span>&copy; 2019</span>
    </v-footer>
  </v-app>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  created() {
    this.fetchAuthUser();
  },

  data: () => ({
    drawer: null
  }),

  computed: {
    ...mapGetters(["getAuthUser"])
  },

  methods: {
    ...mapActions(["fetchAuthUser"]),

    logout() {
      axios.post("logout").then(response => {
        document.location.href = "login";
      });
    }
  }
};
</script>
