<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>[BacklogPersonal]日報</title>
    </head>
    <body>
      <h1>本日の成果</h1>
      <div class=""issue-container>
          @foreach ($issues as $issue)
              <ul class="box">
                  <li class="issue -summary">タイトル: <strong>{{$issue['summary']}}</strong></li>
                  <li class="issue -paragraph">担当者: <strong>{{$issue['assignee']['name']}}</strong></li>
                  <li class="issue -paragraph">期限日: <strong class="strong">{{$issue['dueDate']}}</span></li>
                  <li class="issue -paragraph">作成者: <strong>{{$issue['createdUser']['name']}}</strong></li>
              </ul>
          @endforeach
      </div>
    </body>
</html>
