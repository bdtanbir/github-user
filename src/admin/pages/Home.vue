<template>
  <div class="home">
    <div class="search-box">
      <input type="text" v-model="search" placeholder="Search Username" />
      <!-- <button @click="getRepos">Get User</button> -->
      <ul>
        <li v-for="userItem in userItems" :key="userItem.id">
          <!-- <img :src="userItem.owner.avatar_url" alt="" /> -->
          <!-- {{ userItem.owner.login }} -->
          name
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Home",

  data() {
    return {
      userItems: "",
      search: "",
      username: "",
      msg: "Welcome to Your Vue.js Admin App created by TANBIR",
    };
  },
  // methods: {
  //   getRepos: function () {
  //     return axios
  //       .get("https://api.github.com/users")
  //       .then((response) => {
  //         this.userItems = response.data;
  //         console.log((this.userItems = response.data));
  //       })
  //       .catch((error) => {
  //         console.log(error);
  //       });
  //   },
  // },
  created() {
    this.$http.get("https://api.github.com/users").then(function (response) {
      this.userItems = response.data;
    });
  },
  // computed: {
  //   filteredUsers: function () {
  //     return this.userItems.filter((userItem) => {
  //       return userItem.owner.login.match(this.search);
  //     });
  //   },
  // },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
