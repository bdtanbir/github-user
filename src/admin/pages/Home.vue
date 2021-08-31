<template>
  <div class="home">
    <div class="gtui-search-box">
      <input type="text" v-model="search" placeholder="Search Username" />
      <button @click="searchGit">Get User</button>
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
      return (
        axios
          .get(" https://api.github.com/search/users?q=" + this.search)
          .then((response) => {
            console.dir(response.data.items);
            this.users = response.data.items;
          })
          .catch((error) => {
            console.log(error);
          })
      );
    },
  },
//   created() {
//     return (
//       axios.get("https://api.github.com/search/users?q=" + this.search).then((response) => {
//           this.users = response.data.items;
//       })
//     )
//   },
//   computed: {
//     filteredUsers: function () {
//       return this.users.filter((user) => {
//         return user.login.match(this.search);
//       });
//     },
//   },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
