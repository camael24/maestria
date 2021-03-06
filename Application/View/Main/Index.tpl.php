<?php
/**
 * @var $this \Sohoa\Framework\View\Greut
 */

$this->inherits('hoa://Application/View/base.tpl.php');
$this->block('popup', 'append');
?>
    <section id="popupclasse">
        <section id="inpopup">
            <section class="titre classe">
                <div class="awsm exit"><i class="fa fa-close"></i></div>
                <h3>CHOIX DE LA CLASSE</h3></section>
            <section class="contenu classechx">

                <?php foreach ($classes as $classe) {
                    /**
                     * @var $classe \Application\Entities\Classroom
                     */
                    echo '<h6 data-idclasse="'.$classe->getId().'" data-lvl="3" data-niv="1">'.$classe->getLabel().'</h6>';
                } ?>

            </section>
        </section>
    </section>
    <section id="popupevl">
        <section id="inpopup">
            <section class="titre eval">
                <div class="awsm exit"><i class="fa fa-close"></i> </div>
                <h3 class="username"></h3>
            </section>
            <section id="popupevlcontent" class="contenu inputresult">
            </section>
        </section>
    </section>

<?php
$this->endblock();
$this->block('container');
?>
    <section id="corps" class="evaluer">
        <section id="titre">
            <h3 class="classe">CLASSE <i class="fa fa-caret-right"></i> <span id="classe">?</sup></span></h3>

            <h1>EVALUER <i class="fa fa-caret-right"></i><span id="evalchx">?</span></h1>

        </section>
        <section id="contenu" style="width: 90%">
            <!--      <div class="boutons">
                      <h4 class="optaff">OPTIONS D'AFFICHAGE</h4>
                  </div>-->
            <section id="cases">

            </section>
        </section>
    </section>
<?php
$this->endblock();
$this->block('js:script');
?>
    <script>
        var current_class = null;
        var current_eval = null;
        var current_elv = null;
        var form_state = false;

        function couleur(y) {

            if (y == '') {
                return '0,0';
            }

            var vert, rouge;
            if (y < 50) {
                vert = Math.round(y * 5.1);
                rouge = 255;
            }
            else {
                vert = 255;
                rouge = Math.round(255 - (y - 50) * 5.1);
            }
            return rouge + ',' + vert;
        }



        var loadUsers = function (current_class, current_eval) {
            if (current_class != null && current_eval != null) {

                $.get('/api/classe/' + current_class + '/users/', function (data) {

//                    $('#cases').html('<pre>'+data+'</pre>');
                    var users = JSON.parse(data).log[0];
                    var html = '';

                    for (var i = 0; i < users.length; i++) {

                        html += '<article class="elv" draggable="true" data-idelv="' + users[i].id + '">';
                        html += '<div class="awsm perso" style="color:rgb(255,153,0)"><i class="fa fa-user"></i></div>';
                        html += '<div class="nom">' + users[i].name + '</div>';
                        html += '<div class="awsm taxo" style="color:rgb(51,255,0)">'; // Make color
                        html += '<span><i class="fa fa-book" style="color:rgb('+couleur(users[i].connaitre)+',0)"></i></span>'; // Make color
                        html += '<span><i class="fa fa-rotate-left" style="color:rgb('+couleur(users[i].comprendre)+',0)"></i></span>'; // Make color
                        html += '<span><i class="fa fa-wrench" style="color:rgb('+couleur(users[i].appliquer)+',0)"></i></span>'; // Make color
                        html += '<span><i class="fa fa-star" style="color:rgb('+couleur(users[i].analyser)+',0)"></i></span>'; // Make color
                        html += '</div>';
                        html += '</div>';
                        html += '<div class="prctg">' + users[i].note + ' - '+ users[i].rate +'%</div>';
                        html += '</article>';
                    }

                    $('#cases').html(html);

                });
            }
        };

        var evaluateAnStudent = function (idStudent, eval) {
            var html = '';
            var url = "/api/eval/" + current_eval + "/user/" + idStudent + "/";
            console.log(url);
            $.get(url, function (data) {

                var json = JSON.parse(data);
                var questions = json.data;
                var log = json.log[0];
                var user = log[0]; // current user
                var next = log[1]; // next user
                var prev = log[2]; // previous user

                for (var i = 0; i < questions.length; i++) {

                    var q = questions[i];


                    html += '<article class="note" data-id="' + q.id + '"><aside><h5>' + (i + 1) + ') ' + q.title + '</h5>';
                    switch (q.taxo) {
                        case 1:
                            html += '<div><i class="fa fa-wrench"></i> Connaissance';
                            break;
                        case 2:
                            html += '<div><i class="fa fa-wrench"></i> Compr�hension';
                            break;
                        case 3:
                            html += '<div><i class="fa fa-wrench"></i> Application';
                            break;
                        case 4:
                            html += '<div><i class="fa fa-wrench"></i> Analys';
                            break;
                    }
                    html += '<span class="note">/' + q.note + '</span></div>' +
                        '<div><i class="fa fa-graduation-cap"></i> ' + q.item1 + '</div>' +
                        '<div><i class="fa fa-cogs"></i>' + q.item2 + '</div>' +
                        '</aside><div class="input">';

                    var uid = 'u' + user.id + 'e' + current_eval + 'q' + q.id;
                    var iid = 'i' + user.id + 'e' + current_eval + 'q' + q.id;

                    html += '<p class="options">';
                    if (q.current == 2) {
                        html += '<input type="radio" id="' + iid + '1" name="' + uid + '" value="2" checked /><label for="' + iid + '1" class="top">A</label>';
                    }
                    else {
                        html += '<input type="radio" id="' + iid + '1" name="' + uid + '" value="2"/><label for="' + iid + '1" class="top">A</label>';
                    }
                    if (q.current == 1) {
                        html += '<input type="radio" id="' + iid + '2" name="' + uid + '" value="1" checked /><label for="' + iid + '2" class="mid">B</label>';
                    }
                    else {
                        html += '<input type="radio" id="' + iid + '2" name="' + uid + '" value="1"/><label for="' + iid + '2" class="mid">B</label>';
                    }
                    if (q.current == 0) {
                        html += '<input type="radio" id="' + iid + '3" name="' + uid + '" value="0" checked /><label for="' + iid + '3" class="min">C</label>';
                    }
                    else {
                        html += '<input type="radio" id="' + iid + '3" name="' + uid + '" value="0"/><label for="' + iid + '3" class="min">C</label>';
                    }
                    if (q.current == -1) {
                        html += '<input type="radio" id="' + iid + '4" name="' + uid + '" value="-1" checked />'; // TODO: Modify here
                    }
                    else {
                        html += '<input type="radio" id="' + iid + '4" name="' + uid + '" value="-1"/>'; // TODO: Modify here
                    }
                    html += '</p>';

                    html += '</div></article>';
                }

                // Set student name in title
                $('.username').text('EVALUER ' + user.name + ' SUR ' + user.currentevalname);

                // Set button for next / previous

                html += '<div class="boutons">';

                if (prev != undefined) {
                    html += '<h4 data-idelv="' + prev.id + '">EVALUER ' + prev.name + '</h4>';
                }

                if (next != undefined) {
                    html += '<h4 style="float:right" data-idelv="' + next.id + '">EVALUER ' + next.name + '</h4>'
                }

                html += '</div>';
                $("#popupevlcontent").empty().html(html);
            });

        };



        $('.classechx > h6').click(function () {
            current_class = $(this).data('idclasse');


            $('#classe').html($(this).text());
            $('#popupclasse').slideUp()
        });

        $('.itemchx > a').click(function (e) {
            e.preventDefault();
            current_eval = $(this).data('ideval');


            $('#evalchx').text($(this).text());
            $('#popup').slideUp()

            loadUsers(current_class, current_eval);

        });

        $('body').on('click', '.elv', function () {
            if (current_class != null && current_eval != null) {
                current_elv = $(this).data('idelv');
                sendForm();
                evaluateAnStudent(current_elv);
                $('#popupevl').slideDown();

            }
        }).on('click', '.boutons > h4', function () {
            if (current_class != null && current_eval != null) {
                var id = $(this).data('idelv');
                sendForm();
                evaluateAnStudent(id);
            }
        }).on('click', '.options > input', function () {
            if (current_class != null && current_eval != null) {
                form_state = true;
                console.log($(this).attr('id'));
                sendForm();
            }
        });

        function sendForm() {
            var table = [];
            $('input:checked').each(function (i, e) {
                    table.push(
                        {
                            name: $(e).attr('name'),
                            value: $(e).val()
                        });
                }
            );
            table = JSON.stringify(table);
            $.post('/api/eval/' + current_eval + '/', 'elmt=' + table);

        }
    </script>
<?php
$this->endblock();