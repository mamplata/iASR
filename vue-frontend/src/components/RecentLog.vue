<template>
    <div class="table-responsive">
        <table class="table table-striped table-hover w-100">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Program</th>
                    <th>Department</th>
                    <th>Year Level</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>hehe</td>
                    <td>Kyle Malaki etits</td>
                    <td>IT</td>
                    <td>CCS</td>
                    <td>4th Year</td>
                    <td>00:04:03-00:04:07</td>
                </tr>
                <tr>
                    <td>hehe</td>
                    <td>Boncales Malaki etits</td>
                    <td>IT</td>
                    <td>CCS</td>
                    <td>4th Year</td>
                    <td>00:04:04-00:04:07</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

</script>

<style scoped>
.table-responsive {
    width: 100%;  /* Ensure the table container takes the full width */
    overflow-x: auto;  /* Add scrollable behavior when the table overflows */
}

.table {
    width: 100% !important; /* Make sure the table itself fills the container */
    table-layout: auto; /* Allow the table to adapt to the content size */
}
</style>