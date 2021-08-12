<template>
  <div class="orders" v-if="orders">
    <!-- delete dialog-->
    <md-dialog-confirm
      :md-active.sync="deleteTogal"
      md-title="Are your sure you want to delete?"
      md-content
      md-confirm-text="OK"
      md-cancel-text="Cancel"
      @md-confirm="confirm()"
      @md-cancel="cancel"
    />

    <md-table md-sort="id" md-sort-order="asc" md-card>
      <md-table-toolbar>
        <div class="md-toolbar-section-start">
          <h1 class="md-title">Orders</h1>
        </div>

        <md-field md-clearable class="md-toolbar-section-end">
          <md-input placeholder="Search by name..." v-model="keywords" />
        </md-field>
      </md-table-toolbar>

      <md-table-empty-state
        md-label="No state found"
        :md-description="`No state found for this query. Try a different search term or create a new state.`"
      >
        <md-button class="md-primary md-raised" @click="add()"
          >Create New Order</md-button
        >
      </md-table-empty-state>
      <md-table-row>
        <md-table-head md-numeric>ID</md-table-head>
        <md-table-head>User</md-table-head>
        <md-table-head>Service</md-table-head>

        <md-table-head>Contacts</md-table-head>
        <md-table-head>Addresses</md-table-head>

        <md-table-head>Actions</md-table-head>
      </md-table-row>
      <md-table-row v-for="order in orders.data" :key="order.id">
        <md-table-cell md-numeric>{{ order.id }}</md-table-cell>
        
        <md-table-cell>{{order.service.name}}</md-table-cell>
        <md-table-cell>{{ order.user.name }}</md-table-cell>
        <md-table-cell>
            {{ order.contacts.name }}
            <br>
            {{order.contacts.email}}
            <br>
            {{order.contacts.phone}}
        </md-table-cell>
        <md-table-cell>
            Country :{{ order.addresses.country }}
            <br>
            City :{{order.addresses.city}}
            <br>
            Street :{{order.addresses.street}}
            <br>
            Zip code :{{order.addresses.zip}}
        </md-table-cell>
        <md-table-cell md-label="Actions">
          
          <md-button class="md-icon-button md-accent" @click="remove(order.id)">
            <md-icon>delete</md-icon>
          </md-button>
        </md-table-cell>
      </md-table-row>
    </md-table>
    <pagination :limit="4" :data="orders" @pagination-change-page="get"></pagination>
   
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Orders",
  data: () => ({
    keywords: null,
    orders: null,
    order: null,
    deleteTogal: false,
  }),
  watch: {
    keywords(after, before) {
      this.search();
    },
  },
  methods: {
    search() {
      axios
        .get("admin/search-order", {
          params: {
            keywords: this.keywords,
          },
        })
        .then((res) => {
          this.orders = res.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    get(page = 1) {
      axios
        .get("admin/orders?page=" + page)
        .then((res) => {
          console.log("order: ", res.data.data);
          this.orders = res.data;
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },

    add() {
      this.addTogal = true;
      this.stateData = this.states;
    },
    refresh() {
      this.addTogal = false;
      this.editTogal = false;
      this.get();
    },
    edit(data) {
      this.editTogal = true;
      this.op = data;
    },
    remove(id) {
      this.deleteTogal = true;
      this.selectedId = id;
    },

    confirm() {
      axios
        .delete("admin/orders/" + this.selectedId)
        .then((res) => {
          console.log("deleted", res.data);
          this.get();
        })
        .catch((err) => {
          console.log("Error: ", err);
        });
    },
    cancel() {},
  },
  created() {
     this.get();
  },

  
};
</script>

<style lang="scss" scoped>
.orders {
  width: 100%;

  .add-btn {
    position: fixed;
    bottom: 20px;
    right: 20px;
  }
}
</style>
