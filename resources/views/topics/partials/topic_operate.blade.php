<div class="panel-footer operate">

  <div class="pull-left" style="font-size:15px;">
    <a class="" href="http://service.weibo.com/share/share.php?url={{ urlencode(Request::url()) }}&type=3&pic=&title={{{ $topic->title }}}" target="_blank" title="{{ lang('Share on Weibo') }}">
      <i class="fa fa-weibo"></i>
    </a>
    <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::url()) }}&text={{{ $topic->title }}}&via=phphub.org" class=""  target="_blank" title="{{ lang('Share on Twitter') }}">
      <i class="fa fa-twitter"></i>
    </a>
    <a href="http://www.facebook.com/sharer.php?u={{ urlencode(Request::url()) }}" class=""  target="_blank" title="{{ lang('Share on Facebook') }}">
      <i class="fa fa-facebook"></i>
    </a>
    <a href="https://plus.google.com/share?url={{ urlencode(Request::url()) }}" class=""  target="_blank" title="{{ lang('Share on Google Plus') }}">
      <i class="fa fa-google-plus"></i>
    </a>
  </div>

  <div class="pull-right">

    @if ($currentUser && \App\Models\Attention::isUserAttentedTopic($currentUser, $topic))
      <a class="active" data-ajax="post" data-lang-cancel={{ lang('Cancel') }} data-lang-attent={{ lang('Attent') }}  id="topic-attent-cancel-button" href="javascript:void(0);" data-url="{{ route('attentions.createOrDelete', $topic->id) }}">
        <i class="glyphicon glyphicon-eye-open"></i> <span>{{ lang('Cancel') }}</span>
      </a>
    @else
      <a data-ajax="post" data-lang-cancel={{ lang('Cancel') }} data-lang-attent={{ lang('Attent') }}  id="topic-attent-button" href="javascript:void(0);" data-url="{{ route('attentions.createOrDelete', $topic->id) }}">
        <i class="glyphicon glyphicon-eye-open"></i> <span>{{ lang('Attent') }}</span>
      </a>
    @endif

    @if ($currentUser && \App\Models\Favorite::isUserFavoritedTopic($currentUser, $topic))
      <a class="active" data-ajax="post" data-lang-cancel={{ lang('Cancel') }} data-lang-favorite={{ lang('Favorite') }}  id="topic-favorite-cancel-button" href="javascript:void(0);" data-url="{{ route('favorites.createOrDelete', $topic->id) }}">
        <i class="glyphicon glyphicon-bookmark"></i> <span>{{ lang('Cancel') }}</span>
      </a>
    @else
      <a data-ajax="post" data-lang-cancel={{ lang('Cancel') }} data-lang-favorite={{ lang('Favorite') }}  id="topic-favorite-button" href="javascript:void(0);" data-url="{{ route('favorites.createOrDelete', $topic->id) }}">
        <i class="glyphicon glyphicon-bookmark"></i> <span>{{ lang('Favorite') }}</span>
      </a>
    @endif

    @if ($currentUser && $currentUser->can("manage_topics") )
        <a data-ajax="post" id="topic-recomend-button" href="javascript:void(0);" data-url="{{ route('topics.recommend', [$topic->id]) }}" class="admin {{ $topic->is_excellent == 'yes' ? 'active' : ''}}" title="{{ lang('Mark as Excellent') }}">
        <i class="fa fa-trophy"></i>
        </a>

        <a data-ajax="post" id="topic-wiki-button" href="javascript:void(0);" data-url="{{ route('topics.wiki', [$topic->id]) }}" class="admin {{ $topic->is_wiki == 'yes' ? 'active' : '' }}" title="{{ lang('Mark as Community Wiki') }}">
        <i class="fa fa-graduation-cap"></i>
        </a>

        @if ($topic->order >= 0)
          <a data-ajax="post" id="topic-pin-button" href="javascript:void(0);" data-url="{{ route('topics.pin', [$topic->id]) }}" class="admin {{ $topic->order > 0 ? 'active' : '' }}" title="{{ lang('Pin it on Top') }}">
            <i class="fa fa-thumb-tack"></i>
          </a>
        @endif

        @if ($topic->order <= 0)
            <a data-ajax="post" id="topic-sink-button" href="javascript:void(0);" data-url="{{ route('topics.sink', [$topic->id]) }}" class="admin {{ $topic->order < 0 ? 'active' : '' }}" title="{{ lang('Sink This Topic') }}">
                <i class="fa fa-anchor"></i>
            </a>
        @endif

        <a data-method="delete" id="topic-delete-button" href="javascript:void(0);" data-url="{{ route('topics.destroy', [$topic->id]) }}" title="{{ lang('Delete') }}" class="admin">
            <i class="fa fa-trash-o"></i>
        </a>
    @endif

    @if ( $currentUser && ($currentUser->can("manage_topics") || $currentUser->id == $topic->user_id) )
      <a id="topic-append-button" href="javascript:void(0);" title="{{ lang('Append') }}" class="admin" data-toggle="modal" data-target="#exampleModal">
        <i class="fa fa-plus"></i>
      </a>

      <a id="topic-edit-button" href="{{ route('topics.edit', [$topic->id]) }}" title="{{ lang('Edit') }}" class="admin">
        <i class="fa fa-pencil-square-o"></i>
      </a>
    @endif

  </div>
  <div class="clearfix"></div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="" aria-labelledby="exampleModalLabel" >
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">{{ lang('Append Content') }}</h4>
      </div>

     <form method="POST" action="{{route('topics.append', $topic->id)}}" accept-charset="UTF-8">
         {!! csrf_field() !!}
        <div class="modal-body">

          <div class="alert alert-warning">
              {{ lang('append_notice') }}
          </div>

          <div class="form-group">
              <textarea class="form-control" style="min-height:20px" placeholder="{{ lang('Please using markdown.') }}" name="content" cols="50" rows="10"></textarea>
          </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ lang('Close') }}</button>
            <button type="submit" class="btn btn-primary">{{ lang('Submit') }}</button>
          </div>

      </form>

    </div>
  </div>
</div>
