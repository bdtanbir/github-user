<template>
  <h1>
    <router-link
      :to="{
        name: 'user-single',
        params: { user: user, id: user.id },
      }"
    >
      {{ user.login }}
    </router-link>
  </h1>
</template>

<script>
export default {
  name: "UsersLists",
  props: ["user"],
};
</script>


