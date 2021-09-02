<template>
  <div class="home">
    <div class="gtui-search-box">
      <form @submit.prevent>
        <input
          type="text"
          v-model="search"
          name="search_username"
          placeholder="Search Username"
        />
        <button type="submit" @click="searchGit">submit</button>
      </form>
      <div class="search-result-name">
        <UsersLists v-for="user in users" :key="user.id" :user="user" />
      </div>
    </div>
  </div>
</template>

<script>
// import axios from "axios";
import $ from "jquery";
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
    // searchGit: function () {
    //   return axios
    //     .get(" https://api.github.com/search/users?q=" + this.search)
    //     .then((response) => {
    //       this.users = response.data.items;
    //     })
    //     .catch((error) => {
    //       console.log(error);
    //     });
    // },

    searchGit: function () {
      const that = this;
      $.ajax({
        type: "POST",
        url: ajax_url.ajaxurl,
        data: {
          action: "my_ajaxcall",
          search_username: this.search,
        },
        success: function (data) {
          that.users = data.data.items;
        },
      });
    },
  },
  mounted: function () {},
};
</script>