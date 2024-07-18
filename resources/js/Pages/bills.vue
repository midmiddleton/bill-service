<template>
  <div id="app">
    <header>
      <h1>Bill Management System</h1>
    </header>
    <main>
      <div class="developers">
        <div class="developer">
          <h2>Total number of submitted bills</h2>
          <p>{{ totals.submitted }}</p>
        </div>
        <div class="developer">
          <h2>Total number of approved bills</h2>
          <p>{{ totals.approved }}</p>
        </div>
        <div class="developer">
          <h2>Total number of on-hold bills</h2>
          <p>{{ totals.on_hold }}</p>
        </div>
      </div>
      <section class="main-content">
        <h2>Users</h2>

          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Total bills</th>
                <th>Total submitted</th>
                <th>total Approved</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in users" :key="user.id">
                <td>{{ user.name }}</td>
                <td>{{ user.bills.length}}</td>
                <td>{{ countBillsWithStage(user, 2) }}</td>
                <td>{{ countBillsWithStage(user, 3) }}</td>
              </tr>
            </tbody>
          </table>
      </section>
    </main>
  </div>
</template>

<script>
export default {
  props: {
    users: {
      type: Array,
      required: true
    },
    totals: {
      type: Object,
      required: true
    }
  },
  methods: {
    countBillsWithStage(user, stageId) {
      return user.bills.filter(bill => bill.bill_stage_id === stageId).length;
    }
  },
  created() {
    console.log('Users:', this.users);
    console.log('Totals:', this.totals);
  }
}
</script>

<style>
#app {
  font-family: Arial, sans-serif;
  text-align: center;
  color: #333;
  background-color: #f5f5f5;
}

header {
  background-color: #4CAF50;
  color: white;
  padding: 10px;
}

.developers {
  display: flex;
  justify-content: space-around;
  margin: 20px 0;
}

.developer {
  border: 1px solid #ddd;
  padding: 20px;
  width: 30%;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.main-content {
  background-color: #fff;
  padding: 20px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px 0;
  font-size: 18px;
  text-align: left;
}
th,
td {
  padding: 12px;
  border-bottom: 1px solid #ddd;
}
thead tr {
  background-color: #f2f2f2;
}
tbody tr:hover {
  background-color: #f9f9f9;
}
th {
  background-color: #4CAF50;
  color: white;
}
</style>
