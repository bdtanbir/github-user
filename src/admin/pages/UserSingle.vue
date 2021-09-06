<template>
  <div class="gtui-user-single">
    <div class="search-result-user-details-info">
      <div class="left">
        <img
          v-if="userInfo.avatar_url"
          class="user-image"
          :src="userInfo.avatar_url"
          alt=""
        />
        <h1 v-if="userDetails.name" class="user-title">
          {{ userDetails.name }}
        </h1>
        <h3 class="user-subtitle">{{ userInfo.login }}</h3>
        <p v-if="userDetails.bio" class="user-bio">
          {{ userDetails.bio }}
        </p>
        <span v-if="userDetails.location" class="user-location">
          {{ userDetails.location }}
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
import $ from "jquery";
export default {
  name: "UserSingle",

  data() {
    return {
      userRepos: [],
      userDetails: "",
      userInfo: this.$route.params.user,
    };
  },

  created() {
    const that = this;
    $.ajax({
      type: "POST",
      url: ajax_url.ajaxurl,
      data: {
        action: "my_ajaxcall2",
        clickUser: that.userInfo.login,
      },
      success: function (data) {
        that.userDetails = data.data;
      },
    });
    $.ajax({
      type: "POST",
      url: ajax_url.ajaxurl,
      data: {
        action: "user_repos_callback",
        userRepos: that.userInfo.login,
      },
      success: function (data) {
        that.userRepos = data.data;
      },
    });
  },
};
</script>

<style lang="css" scoped>
</style>
