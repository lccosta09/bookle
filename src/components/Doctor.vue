<template>
    <div>
        <p>{{ doctor.description }}</p>
        <div class="calendar-wrapper">
            <div class="calendar">
                <ul class="pagination pagination-lg">
                    <li class="page-item">
                        <button class="page-link">1</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">2</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">3</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">4</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">5</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">5</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">7</button>
                    </li>
                </ul>
                <ul class="pagination pagination-lg">
                    <li class="page-item">
                        <button class="page-link">8</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">9</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">10</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">11</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">12</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">13</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">14</button>
                    </li>
                </ul>
                <ul class="pagination pagination-lg">
                    <li class="page-item">
                        <button class="page-link">15</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">16</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">17</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">18</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">19</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">20</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">21</button>
                    </li>
                </ul>
                <ul class="pagination pagination-lg">
                    <li class="page-item">
                        <button class="page-link">22</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">23</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">24</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">25</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">26</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">27</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">28</button>
                    </li>
                </ul>
                <ul class="pagination pagination-lg">
                    <li class="page-item">
                        <button class="page-link">29</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">30</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link">31</button>
                    </li>
                    <li class="page-item">
                        <button class="page-link"></button>
                    </li>
                    <li class="page-item">
                        <button class="page-link"></button>
                    </li>
                    <li class="page-item">
                        <button class="page-link"></button>
                    </li>
                    <li class="page-item">
                        <button class="page-link"></button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Doctor',
    props: [
        'doctor'
    ]
};
</script>

<style scoped>
    .calendar-wrapper {
        text-align: center;
    }

    .calendar {
        text-align: left;
        display: inline-block;
    }

    .pagination-lg .page-link {
        padding: 0;
        width: 50px;
        height: 50px;
        border: none;
        border-radius: 0;
    }

    .pagination-lg {
        margin: 0;
    }
</style>
