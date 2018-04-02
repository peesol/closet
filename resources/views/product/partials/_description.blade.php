@foreach($contacts as $contact)
  <div class="full-label padding-15-horizontal" style="height:40px">
    @if($contact->link)
      <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;
      <a class="link-text" href="{{$contact->link}}">{{$contact->body}}<sup>*</sup></a>
    @else
      <span class="contact-btn {{$contact->type}} icon-{{$contact->type}}"></span>&nbsp;<label class="font-grey font-light">{{$contact->body}}</label>
    @endif
  </div>
@endforeach
<div class="panel-body">
  <p class="comment">{!! nl2br(e($product->description)) !!}</p>
</div>
