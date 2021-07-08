@csrf
<div class="container">
  <h2>Profile</h2>
              
  <table class="table table-hover">
    <thead>
      <tr>
        <th>title</th>
        <th>body</th>
        <th>tags</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <!-- <td>{{$articles->title}}</td> -->
        <td>{{$articles->body}}</td>
        <td>{{$articles->tags}}</td>
      </tr>
    </tbody>
  </table>
</div>
<div>
