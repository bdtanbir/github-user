<template>
  <div class="home">
    <div class="gtui-search-box">
      <input
        type="text"
        v-model="search"
        @input="searchGit"
        @change="searchGit"
        placeholder="Search Username"
      />
      <div class="search-result-name">
        <UsersLists v-for="user in users" :key="user.id" :user="user" />
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import UsersLists from "../../components/UsersLists.vue";
export default {
  name: "Home",

  data() {
    return {
      users: [],
      search: "",
      userRepos: [],
    };
  },
  components: {
    UsersLists,
  },
  methods: {
    searchGit: function () {
      return axios
        .get(" https://api.github.com/search/users?q=" + this.search)
        .then((response) => {
          this.users = response.data.items;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>