<template>
  <div class="home">
    <div class="gtui-search-box">
      <input type="text" v-model="search" placeholder="Search Username" />
      <button @click="searchGit">Get User</button>
      <div
        v-if="search.length && resultUser && !showUserDetails"
        @click="getUserRepos"
        class="search-result-name"
      >
        <h1>{{ user.name }}</h1>
      </div>
    </div>

    <div v-if="showUserDetails" class="search-result-user-details-info">
      <div class="left">
        <img
          v-if="user.avatar_url"
          class="user-image"
          :src="user.avatar_url"
          alt=""
        />
        <h1 v-if="user.name" class="user-title">{{ user.name }}</h1>
        <p v-if="user.bio" class="user-bio">
          {{ user.bio }}
        </p>
        <span v-if="user.location" class="user-location">
          {{ user.location }}
        </span>
      </div>
      <div class="right">
        <h1>Repositories</h1>

        <ul>
          <li v-for="item in userRepos" :key="item.id">
            <a :href="item.svn_url" target="_blank">{{ item.name }}</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Home",

  data() {
    return {
      user: [],
      search: "",
      username: "",
      userRepos: [],
      showUserDetails: false,
      resultUser: false,
    };
  },
  methods: {
    // getRepos: function () {
    //   return axios
    //     .get("https://api.github.com/users" + "/" + this.search)
    //     .then((response) => {
    //       this.user = response.data;
    //       console.log((this.user = response.data));
    //     })
    //     .catch((error) => {
    //       console.log(error);
    //     });
    // },
    searchGit: function () {
      this.resultUser = true;
      this.showUserDetails = false;
      return axios
        .get("https://api.github.com/users/" + this.search)
        .then((response) => {
          this.user = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getUserRepos: function () {
      this.showUserDetails = true;
      return axios
        .get("https://api.github.com/users/" + this.search + "/repos")
        .then((response) => {
          this.userRepos = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  // async created() {
  //   const response = await axios.get(
  //     "https://api.github.com/users/" + this.search + "/repos"
  //   );
  //   this.user = response.data;
  //   console.log(response.data);
  // },
  // computed: {
  //   filteredUsers: function () {
  //     return this.user.filter((userItem) => {
  //       return userItem.owner.login.match(this.search);
  //     });
  //   },
  // },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
