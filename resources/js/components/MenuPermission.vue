<template>
  <div>
    <div class="row">
      <div class="col">
        <select
          class="form-select"
          aria-label="Default select example"
          name="user"
          id="user"
          v-model="form.userResult"
        >
          <option value="">Select an User</option>
          <option v-for="user in users" :value="user.id" :key="user.id">
            {{ user.name }}
          </option>
        </select>
      </div>
      <div class="col">
        <ul>
            <label><input type="checkbox" v-model="selectedMenu" value="0"/> All</label>
          <li v-for="menu in menus" :key="menu.id">
            <input
              class="menu"
              type="checkbox"
              name="menu[]"
              v-model="selectedMenu"
              :value="menu.id"
            />
            <label>{{ menu.menuName }}</label>
          </li>
        </ul>
      </div>
      <div class="col">
        <ul>
          <li v-for="submenu in filteredProduct" :key="submenu.id">
            <input
              type="checkbox"
              name="submenu[]"
              id="submenu[]"

              :value="submenu.id"
            />
            <label>{{ submenu.subMenuName }}</label>
          </li>
        </ul>
      </div>
      <div class="col">
        <input
          type="checkbox"
          name="action[]"
          v-model="form.actionResult"
          value="Create"
        /><span class="badge bg-success">Create</span> <br />
        <input
          type="checkbox"
          name="action[]"
          v-model="form.actionResult"
          value="Edit"
        /><span class="badge bg-primary">Edit</span> <br />
        <input
          type="checkbox"
          name="action[]"
          v-model="form.actionResult"
          value="Delete"
        /><span class="badge bg-danger">Delete</span>
      </div>
    </div>
    <div class="text-center">
      <button class="btn btn-primary" @click="add">Submit</button>
    </div>

    <div class="text-center">
      <h1 class="text-success" id="result"></h1>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      done: [],
      selectedMenu: [0],
      menus: [],
      submenus: [],
      users: [],
      form: {
        userResult: "",
        menuResult: [],
        submenuResult: [],
        actionResult: [],
      },
    };
  },
  computed:{
    filteredProduct: function() {
      const app = this,
        menu = app.selectedMenu;

      if (menu.includes(0)){
        return app.submenus;
      }
      else{
        return app.submenus.filter(p =>
        menu.includes(p.menuId)
        );
      }

    },
  },
  methods: {
    menuList() {
      axios.get("/api/menuList").then((response) => {
        this.menus = response.data;
        console.log(response.data);
        // this.productForm.colors = response.data;
      });
    },
    submenuList() {
      axios.get("/api/subMenuList").then((response) => {
        this.submenus = response.data;
        console.log(response.data);
        // this.productForm.colors = response.data;
      });
    },

    userList() {
      axios.get("/api/userlist").then((response) => {
        this.users = response.data;
      });
    },
    add() {
      axios
        .post("/api/menu-permission", {
          user: this.form.userResult,
          menu: this.form.menuResult,
          submenu: this.form.submenuResult,
          action: this.form.actionResult,
        })
        .then((response) => {
          console.log(response.data);
          document.getElementById("result").innerHTML = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  mounted() {
    this.menuList();
    this.userList();
    this.submenuList();
  },
};
</script>
<style>
</style>
