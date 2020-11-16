CREATE TABLE carte (
  id_carte         INTEGER AUTO_INCREMENT,
  titlu            VARCHAR(150) NOT NULL,
  id_categorie	   INTEGER NOT NULL,
  an			   YEAR,
  editura		   VARCHAR(30),
  tip              VARCHAR(10) NOT NULL,
  nr_imprumuturi   INTEGER DEFAULT 0,
  nota             DECIMAL(3, 2) DEFAULT NULL,
  stoc             INTEGER DEFAULT 1,
  descriere        VARCHAR(2000),
  url_fisier       VARCHAR(1000),
    CONSTRAINT pk_id_carte PRIMARY KEY (id_carte)
);


CREATE TABLE autor (
  id_autor   INTEGER AUTO_INCREMENT,
  nume       VARCHAR(30),
  prenume    VARCHAR(30),
    CONSTRAINT pk_id_autor PRIMARY KEY (id_autor)
);

CREATE TABLE carte_autor (
	id_carte 	INTEGER,
    id_autor	INTEGER,
     CONSTRAINT fk_carte_autor_carte FOREIGN KEY (id_carte)
		REFERENCES carte (id_carte),
	 CONSTRAINT fk_carte_autor_autor FOREIGN KEY (id_autor)
		REFERENCES autor (id_autor)
);

CREATE TABLE client (
  id_client           INTEGER AUTO_INCREMENT,
  nume                VARCHAR(20) NOT NULL,
  prenume             VARCHAR(20) NOT NULL,
  telefon             VARCHAR(20) UNIQUE,
  email               VARCHAR(25) UNIQUE,
  adresa              VARCHAR(100),
  data_inregistrare   DATETIME NOT NULL DEFAULT current_timestamp,
  tip				  INTEGER NOT NULL,
  taxa_retur          DECIMAL(6, 2) DEFAULT 0.00,
  username            VARCHAR(40) NOT NULL,
  parola              VARCHAR(255) NOT NULL,
  activ               INTEGER DEFAULT 0,
  token               VARCHAR(35),
    CONSTRAINT pk_id_client PRIMARY KEY (id_client)
);

CREATE TABLE imprumut (
  id_imprumut     INTEGER AUTO_INCREMENT,
  id_client       INTEGER NOT NULL,
  id_carte        INTEGER NOT NULL,
  data_cerere     DATETIME DEFAULT CURRENT_TIMESTAMP,
  data_ridicare   DATE,
  data_retur      DATE,
    CONSTRAINT pk_id_imprumut PRIMARY KEY (id_imprumut, id_client, id_carte, data_cerere)
);

CREATE TABLE review (
  id_review      INTEGER AUTO_INCREMENT,
  email_client   VARCHAR(25),
  id_carte       INTEGER,
  nota           DECIMAL(3, 2) NOT NULL,
  descriere      VARCHAR(200),
    CONSTRAINT pk_id_review PRIMARY KEY (id_review)
);

CREATE TABLE categorie (
	id_categorie		INTEGER AUTO_INCREMENT,
    categorie			VARCHAR(100),
		CONSTRAINT pk_id_categorie PRIMARY KEY (id_categorie)
);

CREATE TABLE judete (
  id_judet INTEGER AUTO_INCREMENT,
  judet VARCHAR(20),
    CONSTRAINT PRIMARY KEY(id_judet)
);

ALTER TABLE imprumut
  ADD CONSTRAINT fk_imprumut_client FOREIGN KEY ( id_client )
    REFERENCES client ( id_client );

ALTER TABLE imprumut
  ADD CONSTRAINT fk_imprumut_carte FOREIGN KEY ( id_carte )
    REFERENCES carte ( id_carte );
    
INSERT INTO categorie (categorie) VALUES
('Arta, arhitectura, fotografie'),
('Atlase si enciclopedii'),
('Biografii si memorii'),
('Business, economie, finante'),
('Dezvoltare personala'),
('Dictionare'),
('Fictiune'),
('Filosofie'),
('Gastronomie'),
('Istorie'),
('Limbi straine'),
('Psihologie'),
('Stiinte');


INSERT INTO autor VALUES
(1,'Yalom','Irvin'),
(2,'Zusak','Markus'),
(3,'Rowling','J. K.'),
(4,'Dutton','Kevin'),
(5,'Harari','Yuval Noah'),
(6,'Hawking','Stephen'),
(7,'Goleman','Daniel'),
(8,'St. Clair','Kassia'),
(9,'Hoffmann','Andrea C.'),
(10,'Ash','Russell'),
(11,'Oliver','Jamie'),
(12,'Schopenhauer','Arthur'),
(13,'Gallo','Carmine'),
(14,'Zusak',' Markus'); 

INSERT INTO carte
VALUES(1,'Minciuni pe canapea',7,2017,'Humanitas Fiction','fizica',0,null,1,'Isi poate pierde un psihiatru mintile? Poate fi el pacalit, sedus, manipulat chiar in timpul sedintelor in care ar trebui sa detina controlul asupra pacientilor? Da, daca o femeie dornica de razbunare hotaraste sa joace rolul de pacienta neajutorata. Plin de revelatii surprinzatoare, intocmai ca duelul unui psihanalist cu mintea omeneasca, romanul lui Yalom ne dezvaluie cat de vulnerabili suntem, fara exceptie, in fata singuratatii si nevoii de iubire.<br>Increzator in propriile forte, tanarul psihanalist Ernest Lash nu ia in seama sfaturile mentorului sau, Marshal Streider, ci re-curge, in timpul sedintelor de terapie, la tehnici experimentale. Insa, in ciuda infa-tuarii psihiatrilor, mintea omeneasca este un teritoriu inca necartografiat si plin de primejdii: stabilind o relatie sincera - crede el - cu o noua pacienta, Carolyne Leftman, Ernest isi deschide tainitele sufletului si devine vulnerabil, neavand habar ca femeia pe care isi inchipuie ca o tra-teaza doreste de fapt sa-l manipuleze si sa-l distruga. Prins intr-o paradoxala relatie terapeutica, in care figura autoritara a medicului a cedat tentatiei confesiunii si i se supune pacientului dominator, Ernest va descoperi nebanuite adevaruri incomode despre sine si despre natura umana, ale carei taine credea ca le cunoaste.','minciunipecanapea.jpg');

INSERT INTO carte
VALUES(2,'Hotul de carti',7,2005,'RAO','fizica',0,null,1,'Este anul 1939. Germania nazista. Tara isi tine rasuflarea. Moartea nu a avut niciodata mai mult de lucru, si va deveni chiar mai ocupata. Liesel Meminger si fratele ei mai mic sunt dusi de catre mama lor sa locuiasca cu o familie sociala in afara orasului München. Tatal lui Liesel a fost dus departe sub soapta unui singur cuvant nefamiliar - Kommunist -, iar Liesel vede in ochii mamei sale teama unui destin similar. Pe parcursul calatoriei, Moartea ii face o vizita baietelului si o observa pe Liesel. Va fi prima dintre multe intalniri apropiate. Langa mormantul fratelui ei, viata lui Liesel se schimba atunci cand ea ridica un singur obiect, ascuns partial in zapada. Este Manualul Groparului, lasat acolo din greseala, si este prima ei carte furata. Astfel incepe o poveste despre dragostea de carti si de cuvinte, pe masura ce Liesel invata sa citeasca cu ajutorul tatalui ei adoptiv, care canta la acordeon. In curand, va fura carti de la incendierile de carti organizate de nazisti, din biblioteca sotiei primarului, si de oriunde le mai putea gasi. Hotul de carti este o poveste despre puterea cuvintelor de a creea lumi. Cu o scriitura superb maiestrita si arzand cu intensitate, premiatul autor Marcus Zusak ne-a daruit una dintre cele mai durabile povesti ale timpurilor noastre.','hotuldecarti.jpg');

INSERT INTO carte
VALUES(3,'Harry Potter and the Sorcerer''s Stone',11,1999,'Scholastic','fizica',0,null,1,'Harry Potter has never even heard of Hogwarts when the letters start dropping on the doormat at DECIMAL four, Privet Drive. Addressed in green ink on yellowish parchment with a purple seal, they are swiftly confiscated by his grisly aunt and uncle. Then, on Harry''s eleventh birthday, a great beetle-eyed giant of a man called Rubeus Hagrid bursts in with some astonishing news: Harry Potter is a wizard, and he has a place at Hogwarts School of Witchcraft and Wizardry. An incredible adventure is about to begin! These new editions of the classic and internationally bestselling, multi-award-winning series feature instantly pick-up-able new jackets by Jonny Duddle, with huge child appeal, to bring Harry Potter to the next generation of readers.','HPsorcerer.jpg');

INSERT INTO carte
VALUES(4,'Harry Potter and the Chamber of Secrets',11,2000,'Scholastic','fizica',0,null,1,'Harry Potter''s summer has included the worst birthday ever, doomy warnings from a house-elf called Dobby, and rescue from the Dursleys by his friend Ron Weasley in a magical flying car! Back at Hogwarts School of Witchcraft and Wizardry for his second year, Harry hears strange whispers echo through empty corridors - and then the attacks start. Students are found as though turned to stone… Dobby''s sinister predictions seem to be coming true. These new editions of the classic and internationally bestselling, multi-award-winning series feature instantly pick-up-able new jackets by Jonny Duddle, with huge child appeal, to bring Harry Potter to the next generation of readers.','HPchamber.jpg');

INSERT INTO carte
VALUES(5,'Intelepciunea psihopatilor',12,2013,'Globo','fizica',0,null,1,'Optimismul extrem este o marca distinctiva a psihopatilor, ei fiind mereu in stare sa intoarca pana si cea mai pacatoasa situatie in favoarea lor. Manat de curiozitate, Dutton incepe un periplu amplu si epuizant intre cele mai cunoscute laboratoare psihologice, inchisori de maxima securitate, tribunale si birourile luxoase ale diferitelor categorii de lideri. El incearca, pe diferite cai, sa patrunda in mintea acelor oameni care si-au facut din crima un mod de viata, de la cei mai duri soldati din teatrele de lupta din Irak si Afganistan, pana la cei mai periculosi criminali din cel mai bine pazit spital de psihiatrie din regatul britanic. La urma urmelor, sugereaza psihologul, diferenta intre aceste categorii, si multe altele – chirurgi, manageri, violatori, brokeri, escroci de anvergura, politicieni, preoti carismatici – este de grad, nu de esenta.<br>De-a lungul analizelor sale, Dutton subliniaza ideea ca megalomania, caracteristica psihopatilor, se inrudeste indeaproape cu setul de trasaturi atat de recompensate si pretuite in societatea capitalista a zilelor noastre. El face apel la un studiu amplu, din 2005, care compara profilele liderilor din zona afacerilor cu acelea ale unor criminali internati sub paza stricta. Rezultatul este uimitor: se pare ca trasaturile psihopatice – precum farmecul superficial, egocentrismul, independenta exacerbata si atentia extrem de concentrata – se regasesc mult mai frecvent in salile luxoase de sedinte decat in celulele cu gratii in care sunt tinuti criminalii. Diferenta – caci o diferenta trebuie sa existe, nu-i asa? – rezida in context, in mediul in care au fost incurajate sa se dezvolte aceste abilitati: social sau antisocial.','intelepciuneapsihopatilor.jpeg');

INSERT INTO carte
VALUES(6,'Sapiens. Scurta istorie a omenirii',10,2011,'Polirom','fizica',0,null,1,'Acum 100.000 de ani, pe pamint existau cel putin sase specii de oameni. Astazi exista una singura: noi, Homo sapiens. Ce s-a intimplat cu celelalte? Si cum am ajuns sa fim stapinii planetei? De la inceputurile speciei noastre si rolul pe care l-a jucat in ecosistemul global pana in modernitate, Sapiens imbina istoria si stiinta pentru a pune in discutie tot ce stim despre noi insine, ne arata cum ne-am unit ca sa construim orase, regate si imperii, cum am ajuns sa credem in zei, in legi si in carti, dar si cum am devenit sclavii birocratiei, ai consumerismului si ai cautarii fericirii. De asemenea, ne indeamna sa privim in viitor, caci de cateva decenii am inceput sa incalcam legile selectiei naturale care au guvernat viata in ultimii patru miliarde de ani. Dobandim capacitatea de a modela nu doar lumea din jurul nostru, ci si pe noi insine. Incotro ne duce aceasta si ce vrem sa devenim?<br><br>Interesanta si provocatoare... Ne ajuta sa intelegem de cit de putin timp sintem pe acest pamint, de cit de putin timp exista lucruri ca agricultura sau stiinta si de ce este bine sa nu le luam ca pe ceva de la sine inteles.” - Barack Obama<br><br>„O istorie a civilizatiei captivanta, provocatoare... combinata cu o gindire nonconformista si fapte uimitoare. Aceasta carte fascinanta si distrugatoare de mituri nu poate fi rezumata... pur si simplu trebuie s-o citesti.” - Financial Times<br><br>„In aceasta analiza exhaustiva a istoriei oamenilor, Harari le ofera cititorilor ocazia sa reconsidere totul: de la supravietuirea lui Homo sapiens pina la fascinanta chestiune a modului in care societatea se organizeaza prin fictiuni.” - Booklist<br><br>„Sapiens ii poarta pe cititori intr-un tur rapid al istoriei speciei noastre... o lectura importanta pentru un sapiens cu preocupari serioase, care reflecteaza asupra lui insusi.” - The Washington Post','sapiens.jpeg');

INSERT INTO carte
VALUES(7,'Scurta istorie a timpului. De la Big Bang la gaurile negre',10,2010,'Humanitas','fizica',0,null,1,'Nici o carte de stiinta nu s-a bucurat vreodata de popularitatea Scurtei istorii a timpului: timp de mai bine de patru ani s-a aflat pe lista de bestselleruri din The Sunday Times, mai mult decat orice alta carte. Explicatia acestui succes tine de natura intrebarilor pe care le pune aici Stephen Hawking, unul dintre cei mai mari savanti contemporani, devenit, alaturi de Einstein, un simbol al stiintei: Cum s-a nascut universul? Este timpul reversibil? Este spatiul nemarginit? Exista si alte dimensiuni spatiale, care scapa perceptiei noastre? Arta lui Hawking e de a gasi imagini intuitive, pregnante, prin care stimuleaza fantezia si curiozitatea oricarui cititor, fie ca este sau nu initiat in fizica fundamentala.<br><br>"De unde vine universul? Cum si cand a inceput? Va ajunge la un sfarsit, si daca da, cum? Acestea sunt intrebari care ne intereseaza pe toti. Stiinta moderna a devenit insa atat de tehnica, incat numai un numar foarte mic de specialisti sunt capabili sa stapaneasca matematica utilizata pentru descrierea lor. Totusi, ideile de baza privind originea si soarta universului pot fi enuntate fara utilizarea matematicii, intr-o forma pe care o pot intelege oamenii care nu au educatie stiintifica. Este ceea ce am incercat sa fac in aceasta carte." (STEPHEN W. HAWKING)','scurtaistorieatimpului.jpeg');

INSERT INTO carte
VALUES(8,'Inteligenta emotionala',5,2009,'Curtea Veche','fizica',0,null,1,'Cartea lui Daniel Goleman a marcat o revolutie uluitoare in psihologie prin analiza importantei covarsitoare a emotiilor in dezvoltarea personalitatii umane. Studiul sau ne explica cum, atunci cand ne intelegem sentimentele, situatia in care ne aflam devine mai limpede. Descoperim chiar un nou mod de a privi cauzele bolilor care ne macina familia si societatea.<br><br>Preluand rezultatele cercetarilor contemporane asupra creierului si comportamentului, autorul propune extinderea conceptului de inteligenta. Este binecunoscut termenul de IQ - coeficientul care masoara inteligenta umana innascuta si care nu prea poate fi ameliorat pe parcursul vietii. Dar autorul a deschis calea unei psihologii care acordã un interes egal si inteligentei sentimentelor.<br><br>Inteligenta emotionala (EQ) presupune in primul rand constientizare de sine, autodisciplina si empatie. Ea da seama de felul in care ne controlam impulsurile si sentimentele. Desi copilaria este extrem de importanta in punerea unor baze solide pentru dezvoltarea inteligentei emotionale, ea poate fi imbunatatita si cultivata inclusiv la varsta adulta.<br><br>"Oricine este interesat de leadership ar trebui sa citeasca aceasta carte." -The New York Times Book Review','inteligentaemotionala.jpeg');

INSERT INTO carte
VALUES(9,'Culorile si viata lor secreta',1,2017,'Baroque Books & Arts','fizica',0,null,1,'Neobisnuitele povesti ale celor mai seducatoare nuante, ale celor mai fascinanti pigmenti si ale celor mai fragile umbre. De la galbenul-solar imaginat de Van Gogh intr-o simfonie de tente crude sau frante la cel mai stins Veronese pornit spre albastru-regal, de la puritatea morala si spirituala din gandirea lui Le Corbusier la albul-infinit modelat de Rodin, de la carbunele de pe peretii pesterii din Lascaux la perioada albastra a lui Picasso, de la verdele-Kelly la purpura imperiala si rozul-fluorescent al generatiei punk, un foc de artificii, un studiu fara asemanare al civilizatiei umane. Cutreierand rafinat universul politicii si al modei, al artelor si al razboiului, Culorile si viata lor secreta soptesc istoria vie a propriei noastre culturi.<br><br>„O aventura in jurul lumii, fara sa iesi din cutia ta de acuarele.“ - SIMON GARFIELD<br><br>Acest volum este tiparit la tipografia Monitorul Oficial pe hartie Cocoon Offset, o gama inovatoare de hartii offset extra-albe, certificate FSC® si 100% reciclate, asigurand o reproducere a culorilor consistenta si de inalta clasa, mentinand o viteza de imprimare excelenta. Prin alegerea Cocoon offset, niciodata nu va trebui sa faci un compromis intre gradul de alb si acreditarile de mediu.','culorile.jpeg');

INSERT INTO carte
VALUES(10,'Povestea Faridei. Fata care a invins ISIS',3,2016,'RAO','fizica',0,null,1,'Primele memorii ale unei supravietuitoare a terorii ISIS. Toti barbatii au fost omorati. Toate femeile au devenit sclave. Farida a reusit sa evadeze. In august 2014, Farida, o adolescenta obisnuita, incerca sa se bucure de vacanta de vara. Fata locuia intr-o regiune muntoasa din nordul Irakului, iar ce a urmat este de neimaginat. Satul ei a cazut prada unui atac pus la cale de ISIS. Acestui atac i-au cazut victime toti barbatii, inclusiv tatal si unul dintre fratii Faridei, iar femeile au fost luate ostatice si supuse unor chinuri atroce, de la batai si violuri pana la vanzare in piata publica asemenea unor vite. Dupa sapte tentative esuate de a se sinucide, Farida va profita, impreuna cu alte cinci tinere, de o ocazie favorabila si va fugi in desertul libian. Farida a dovedit un curaj incredibil intr-o situatie care parea fara iesire si s-a hotarat sa faca publica povestea ei de viata. Ne aflam in prezenta memoriilor impresionante ale unei tinere femei, care arata ce inseamna cu adevarat lupta pentru supravietuire a unor oameni nevinovati, prinsi in vartejul razbunarii inexplicabile a membrilor ISIS.','povesteafaridei.jpeg');

INSERT INTO carte
VALUES(11,'Lumea in date si fapte. Enciclopedia familiei tale',2,2017,'Prut','fizica',0,null,1,'Este cartea perfecta pentru a afla tot ce trebuie sa stii - si mult mai mult... Este o carte superba ce contine sute de fotografii, oferind informatii despre o foarte larga gama de subiecte: cele mai noi tehnologii si cele mai mari realizari, cele mai rapide animale, cele mai mari constructii, cele mai importante evenimente, celebritati si recorduri mondiale in diferite domenii. Cartea este impartita in 20 de sectiuni - Universul, Planeta Pamant, Istoria mondiala, Corpul omenesc, Stiinta si tehnologie, Tarile lumii, Arte sunt doar cateva dintre acestea. Trimiterile la adresele web le ofera cititorilor posibilitatea sa exploreze detaliat subiectele prezentate.','lumeaindatesifapte.jpeg');

INSERT INTO carte
VALUES(12,'5 ingrediente. Mese rapide & usoare',9,2017,'Curtea Veche','fizica',0,null,1,'Jamie Oliver, autorul celor mai bine vandute carti culinare din toate timpurile in Marea Britanie, revine cu o lucrare senzationala. Concentrandu-se pe combinatii incredibile de 5?ingrediente, a creat 130 de retete, pe baza carora puteti prepara bunatati pentru mesele zilnice. Autorul va da idei pentru toate tipurile de mancaruri, de la salate, paste, pui si peste la feluri inedite cu legume, orez si carne, fara a lipsi mult indragitele dulciuri. Retetele ofera maximum de savoare cu minimum de efort, Jamie dovedind o inspiratie debordanta.<br><br>Mese rapide & usoare se concentreaza, in integralitatea ei, pe combinatii culinare geniale, formate din numai cinci ingrediente. Acestea se potrivesc de minune laolalta, rezultand preparate delicioase, cu maximum de aroma si, totodata, cu minimum de efort din partea voastra. Sunt mancaruri pe care le puteti duce la masa in 30 de minute sau chiar mai putin. Unele pot fi pregatite uluitor de rapid?– sa zicem, in 10?minute de lucru efectiv –, dupa care cuptorul (ori aragazul) va va desavarsi efortul. Odata inarmat cu aceasta carte, as vrea ca fiecare dintre voi sa gateasca orice, cu placere, pornind de la zero – n-ar avea nicio scuza pentru a nu izbuti! Am conceput-o cat mai simplu cu putinta, astfel incat orice novice sa poata deveni autorul unor mancaruri extraordinare, celebrand savorile a doar cinci ingrediente in oricare zi. Iar asta, indiferent de ocazie – de la o cina rapida din timpul saptamanii pana la un imbelsugat ospat de weekend cu prietenii','5ingrediente.jpeg');

INSERT INTO carte
VALUES(13,'Arta de a fi fericit (mic tratat de eudemonologie)',8,2018,'Cartex 2000','fizica',0,null,1,'Cele doua texte care formeaza prezentul volum (Schopenhauer educator, apartinand lui Nielzsche si Arta de a fi fericit, lui Schopenhauer) sunt realizate intr-o relativa autonomie. Apropierea lor, inspirata de o structura dialogica implicita, este si tipul de organizare pe care l-am gandit pentru colectia Forma mentist punerea impreuna, uneori dialectica, a doua texte a caror independenta favorizeaza pluralitatea argumentelor. Suntem intr-un algoritm de tip paraconsistent, unde nu importa valabilitatea absoluta a soritului, ci geometria variabila a argumentatiei.<br><br>Cele 50 de reguli pentru a dobandi fericirea, aditionate in lucrarea postuma a lui Schopenhauer, nu contrazic esenta sale pesimiste: "Nu cautam decat linistea si, in limitele posibilului, absenta suferintei", "Considera nenorocirea actuala o mica parte din ceea ce s-ar putea intampla." Schopenhauer pesimistul, care nu crede in fericire, ne cere luciditate in confruntarea cu neajunsurile vietii. Nu putem fi fericiti! Cu siguranta! Dar putem evita suferinta...<br><br>Forma mentis inseamna starea mintii. A carei minti? A individului? Nu aceea a unui singur individ, ci a unui numar suficient de mare de indivizi pentru a putea vorbi de o stare colectiva. Exista asa ceva? Peste tot unde vedem ca lumea se comporta la fel: un milion de tineri poarta simultan aceiasi blugi, eventual rupti, lumea se supune modei, exista mode intelectuale si filosofii la moda. Forma mintii e deci un indicator bun pentru a explica de ce anumite carti de filozofie au schimbat societatea si continua sa o influenteze cu fiecare noua generatie de cititori.','artadeafifericit.jpeg');

INSERT INTO carte
VALUES(14,'Vorbeste ca la TED. Cele 9 secrete ale vorbitului in public ale celor mai stralucite minti ale lumii',4,2019,'ACT si Politon','fizica',0,null,1,'"Vorbeste ca la TED" de Carmine Gallo este o carte pe care o vei citi cu acelasi entuziasm, si daca prin natura meseriei pe care o practici esti nevoit sa sustii prezentari si sa vorbesti adesea in public, si daca esti pur simplu curios cum ajung discursurile de la conferintele TED (Tehnologie, Educatie, Design) sa stranga milioane de vizualizari. Cartea te va convinge ca lumea este inca flamanda de idei extraordinare prezentate intr-un mod atractiv si te va invata sa fii pregatit pentru situatiile in care ti se vor cere idei magnifice, prezentate uluitor.<br><br>Carmine Gallo, autorul lucrarii de fata, dar si al bestsellerului The Presentation Secrets of Steve Jobs, este consilierul in comunicare al celor mai admirate branduri din lume. Fost reporter principal de stiri si corespondent pentru CNN si CBS, Gallo este un orator de referinta, care a lucrat cu directori executivi de la Intel, Cisco, Chevron, Hewlett-Packard, Coca-Cola, Pfizer, etc. si care semneaza editorialul "My Communications Couch" de pe Forbes.com.<br><br>Pornind de la premisa ca ideile sunt moneda secolului 21, dar ca o idee buna trebuie sa fie comunicata cu pricepere pentru a da roade, Carmine Gallo se angajeaza sa-ti fie mentor pe calea de a deveni un vorbitor in public mai bun. Potrivit lui Gallo, nu poti fi un bun antreprenor fara a stapani pe deplin arta vorbitului in public, fara a fi capabil sa intelegi stiinta si arta de a convinge.<br><br>In timpul documentarii pentru Talk Like TED, Gallo a studiat si analizat mai bine de 500 de prezentari TED (adica, peste 150 de ore) a discutat personal cu vorbitori de succes de la TED, dar si cu psihologi si specialisti in comunicare, incercand sa descifreze care sunt secretele celor mai valoroase discursuri. Dincolo de niste observatii generale, Gallo a ajuns la concluzia ca toti vorbitorii de la TED au in comun aceleasi noua secrete pe care ni le dezvaluie in cartea de fata.','vorbestecalated.jpeg');

INSERT INTO carte VALUES 
(15,'Hotul de carti',7,2005,'RAO','digitala',0,null,1,'','https://drive.google.com/file/d/1msEHq4M8aR5Zo3jZkpxAq3-kkI_ro0IF/view?usp=sharing'),
(16,'Gateste in 30 de minute cu Jamie',9,2012,'Curtea Veche','digitala',0,null,1,'','https://drive.google.com/file/d/1g1m2hm1Bwl7K3DLxg6nfV3eaWaPmPlEI/view?usp=sharing');

INSERT INTO carte_autor VALUES
(1,1),
(2,2),
(3,3),
(4,3),
(5,4),
(6,5),
(7,6),
(8,7),
(9,8),
(10,9),
(11,10),
(12,11),
(13,12),
(14,13),
(15,14),
(16,11);

INSERT INTO judete (judet) VALUES
('ALBA'),
('ARAD'),
('ARGES'),
('BACAU'),
('BIHOR'),
('BISTRITA-NASAUD'),
('BOTOSANI'),
('BRASOV'),
('BRAILA'),
('BUCURESTI'),
('BUZAU'),
('CARAS-SEVERIN'),
('CALARASI'),
('CLUJ'),
('CONSTANTA'),
('COVASNA'),
('DAMBOVITA'),
('DOLJ'),
('GALATI'),
('GIURGIU'),
('GORJ'),
('HARGHITA'),
('HUNEDOARA'),
('IALOMITA'),
('IASI'),
('ILFOV'),
('MARAMURES'),
('MEHEDINTI'),
('MURES'),
('NEAMT'),
('OLT'),
('PRAHOVA'),
('SATU MARE'),
('SALAJ'),
('SIBIU'),
('SUCEAVA'),
('TELEORMAN'),
('TIMIS'),
('TULCEA'),
('VASLUI'),
('VALCEA'),
('VRANCEA');


-- SELECT DISTINCT id_categorie
-- FROM carte JOIN categorie USING (id_categorie)
-- WHERE tip='digitala'
-- ORDER BY categorie;

-- SELECT titlu, nume, prenume, url_fisier
-- FROM carte JOIN carte_autor USING (id_carte)
-- JOIN autor USING (id_autor)
-- WHERE tip='digitala'
-- AND 7 = id_categorie;


-- SELECT DISTINCT titlu -- , prenume, nume, url_fisier
-- FROM carte JOIN carte_autor USING (id_carte)
-- JOIN autor USING (id_autor)
-- WHERE tip='digitala'
-- AND id_categorie = 7;

-- SELECT prenume, nume, url_fisier
-- FROM carte JOIN carte_autor USING (id_carte)
-- JOIN autor USING (id_autor)
-- WHERE tip='digitala'
-- AND id_categorie = 7
-- AND titlu = (SELECT DISTINCT titlu -- , prenume, nume, url_fisier
-- 				FROM carte JOIN carte_autor USING (id_carte)
-- 				JOIN autor USING (id_autor)
-- 				WHERE tip='digitala'
-- 				AND id_categorie = 7);


-- SELECT titlu, prenume, nume, categorie, url_fisier, COUNT(id_imprumut)
-- FROM carte c JOIN carte_autor ca USING (id_carte)
-- JOIN autor a USING (id_autor)
-- JOIN categorie cat USING (id_categorie)
-- JOIN imprumut i USING (id_carte)
-- WHERE id_client = 5
-- GROUP BY titlu;  -- $_SESSION['id']

INSERT INTO imprumut VALUES
(1,5,1,current_timestamp(), current_timestamp(), current_timestamp() + 15);

INSERT INTO imprumut VALUES
(2,5,1,current_timestamp(), current_timestamp(), current_timestamp() + 15);

INSERT INTO imprumut VALUES
(3,5,2,current_timestamp(), current_timestamp(), current_timestamp() + 15);

INSERT INTO imprumut VALUES
(4,5,1,current_timestamp(), current_timestamp(), current_timestamp() + 15);

INSERT INTO imprumut VALUES
(5,5,2,current_timestamp(), current_timestamp(), current_timestamp() + 15);

INSERT INTO imprumut VALUES
(6,5,3,current_timestamp(), current_timestamp(), current_timestamp() + 15);

INSERT INTO imprumut VALUES
(7,5,4,current_timestamp(), current_timestamp(), current_timestamp() + 15);

CREATE TABLE user_favourites (
	id_client		INTEGER,
    id_carte		INTEGER,
    PRIMARY KEY (id_client, id_carte)
);

ALTER TABLE user_favourites
ADD CONSTRAINT fk_favs_client foreign key (id_client) REFERENCES client(id_client);

ALTER TABLE user_favourites
ADD CONSTRAINT fk_favs_carte foreign key (id_carte) REFERENCES carte(id_carte);

INSERT INTO user_favourites VALUES
(5,1), (5,2);

-- SELECT titlu, nume, prenume, categorie, url_fisier
-- FROM carte JOIN carte_autor USING (id_carte)
-- JOIN autor USING (id_autor)
-- JOIN categorie USING (id_categorie)
-- JOIN user_favourites USING (id_carte)
-- WHERE id_client = 5;


SELECT titlu, categorie, prenume, nume, descriere, stoc
FROM carte JOIN categorie USING (id_categorie) 
JOIN carte_autor USING (id_carte) JOIN autor USING (id_autor)
WHERE tip='fizica';


DELETE FROM user_favourites 
WHERE id_client=5
AND id_carte=2;
















