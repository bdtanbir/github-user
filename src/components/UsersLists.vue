<template>
  <h1>
    <router-link
      :to="{
        name: 'user-single',
        params: { user: user, id: user.id },
      }"
    >
      <img :src="user.avatar_url" alt="" /> {{ user.login }}
    </router-link>
  </h1>
</template>

<script>
export default {
  name: "UsersLists",
  props: ["user"],
};
</script>


