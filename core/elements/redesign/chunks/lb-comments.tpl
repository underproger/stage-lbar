{* Комментарии статьи (шаблон «Блог - статья») — вместо row-comment-inst / row-comment-message-inst в content-blog.
   EasyComm как раньше: [[!ecMessages]] (ветка resource-<id>, до 80, только опубликованные; tpl lb.commentRow) и [[!ecForm]]
   с прежними письмами и модерацией (форма — lb.ecForm, как в окне отзывов; JS отправки — easyComm из старого custom.js).
   Якорь #review — как было (на него ведёт счётчик в баннере). Заголовок — не H2 (у старого блока заголовка не было). *}
{$_modx->lexicon->load('babel:translate')}
<section class="lb-comments" id="lb-comments">
    <div class="lb-comments__bg" aria-hidden="true"></div>
    <div class="lb-comments__inner">
        <div id="review"></div>
        <div class="lb-comments__head">
            <div class="lb-comments__title">{'lbar.rd.blog.comments' | lexicon} <span class="lb-comments__count">[[!ecMessagesCount]]</span></div>
        </div>
        <div class="lb-comments__grid">
            <div class="lb-comments__list">
                [[!ecMessages? &tpl=`lb.commentRow` &limit=`80` &tplWrapper=`@INLINE [[+output]]`]]
            </div>
            <div class="lb-comments__form">
                <div class="lb-comments__form-t">{'lbar.reviews.form.title' | lexicon}</div>
                [[!ecForm?
                    &tplForm=`lb.ecForm`
                    &tplSuccess=`tpl.ecForm.Success.Blog`
                    &tplNewEmailManager=`tpl.ecForm.New.Email.Manager.Blog`
                    &tplUpdateEmailUser=`tpl.ecForm.Update.Email.User.Blog`
                    &tplNewEmailUser=`tpl.ecForm.New.Email.User.Blog`
                ]]
            </div>
        </div>
    </div>
</section>
