<template>
  <div id="app" class="font-sans text-center text-gray-700 bg-gray-100 min-h-screen">
    <header class="bg-green-600 text-white p-4">
      <h1 class="text-3xl font-bold">Bill Management System</h1>
    </header>
    <main class="p-4">
      <div class="flex justify-around mb-8">
        <div class="p-4 bg-white rounded shadow w-1/3 mx-2">
          <h2 class="text-xl font-semibold">Total number of submitted bills</h2>
          <p class="text-lg">{{ totals.submitted }}</p>
        </div>
        <div class="p-4 bg-white rounded shadow w-1/3 mx-2">
          <h2 class="text-xl font-semibold">Total number of approved bills</h2>
          <p class="text-lg">{{ totals.approved }}</p>
        </div>
        <div class="p-4 bg-white rounded shadow w-1/3 mx-2">
          <h2 class="text-xl font-semibold">Total number of on-hold bills</h2>
          <p class="text-lg">{{ totals.on_hold }}</p>
        </div>
      </div>
      <section class="bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Users</h2>
        <table class="min-w-full bg-white rounded shadow">
          <thead>
            <tr>
              <th class="py-2 px-4 border-b">Name</th>
              <th class="py-2 px-4 border-b">Total bills</th>
              <th class="py-2 px-4 border-b">Total submitted</th>
              <th class="py-2 px-4 border-b">Total approved</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id" class="hover:bg-gray-100">
              <td class="py-2 px-4 border-b">{{ user.name }}</td>
              <td class="py-2 px-4 border-b">{{ user.bills.length }}</td>
              <td class="py-2 px-4 border-b">{{ countBillsWithStage(user, 2) }}</td>
              <td class="py-2 px-4 border-b">{{ countBillsWithStage(user, 3) }}</td>
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
