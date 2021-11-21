<div class="container pg-elections-candidats">
  <div class="row bloc-titre">
    <div class="col-12">
      <h1><?= $title ?></h1>
    </div>
  </div>
</div>
<div class="container-fluid pg-elections-candidats infosIndividual py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-lg-7 my-4">
        <h2>Informations</h2>
        <p>Les <?= mb_strtolower($election['libelle']) ?> <?= $election['dateYear'] ?> se déroulent en deux tours.</p>
        <p>Le premier tour <?= $today > $election['dateFirstRound'] ? "s'est tenu" : "se tiendra" ?> le <?= $election['dateFirstRoundFr'] ?>, tandis que le second tour <?= $today > $election['dateSecondRound'] ? "s'est déroulé" : "se déroulera" ?> le <?= $election['dateSecondRoundFr'] ?>.</p>
        <?php if ($election['candidates']): ?>
          <p>
            Découvrez sur cette page les députés candidats aux <?= mb_strtolower($election['libelle']) ?> de <?= $election['dateYear'] ?>.
          </p>
          <p>
            <?php if ($candidatsN): ?>
              Nous avons répertorié <b><?= $candidatsN ?> député<?= $candidatsN > 1 ? "s" : NULL ?> candidat<?= $candidatsN > 1 ? "s" : NULL ?></b>.
            <?php else: ?>
              Nous avons jusqu'à présent répertorié <span class="font-weight-bold">aucun député candidat</span>.
            <?php endif; ?>
          </p>
          <?php if ($state == 1): ?>
            <p>
              De ces candidats, <b><?= $candidatsN_second ?> député<?= $candidatsN_second > 1 ? "s se sont maintenus" : " s'est maintenu" ?> pour le second tour</b>.
            </p>
          <?php endif; ?>
          </p>
          <p>Un député candidat ne se trouve pas dans la liste ? N'hésitez pas à nous le faire savoir: <a href="mailto:info@datan.fr">contact@datan.fr</a> !</p>
        <?php endif; ?>
      </div>
      <div class="col-md-4 col-lg-5 d-flex justify-content-center align-items-center">
        <?php if (!empty($election['resultsUrl'])): ?>
          <span class="url_obf btn btn-light btn-lg" url_obf="<?= url_obfuscation($election['resultsUrl']) ?>">
            Résultats
          </span>
        <?php else: ?>
          <span class="url_obf btn btn-light btn-lg" url_obf="<?= url_obfuscation("https://elections.interieur.gouv.fr/") ?>">
            Résultats
          </span>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>
<div class="container pg-elections-candidats py-5">
  <div class="row">
    <div class="col-md-8 col-lg-7">
      <?php $this->load->view('elections/results/'.$election['slug'].'.php') ?>
    </div>
    <?php if (!empty($electionInfos)): ?>
      <div class="col-md-8 col-lg-4 offset-lg-1 mt-5 mt-lg-0">
        <div class="mt-4 infosGeneral">
          <h2 class="title ml-md-5 ml-3">Mieux comprendre</h2>
          <div class="px-4">
            <?= $electionInfos ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <?php if ($election['candidates']): ?>
    <div class="row mt-5 mb-3">
      <div class="col-12">
        <h2>Retrouvez les députés candidats aux <?= mb_strtolower($election['libelle']) ?> de <?= $election['dateYear'] ?></h2>
      </div>
      <div class="col-12 d-flex flex-column flex-lg-row">
        <div class="d-flex flex-even px-2">
          <div class="d-flex align-items-center">
            <span class="candidatsN"><?= $candidatsN ?></span>
          </div>
          <div class="d-flex align-items-center ml-4">
            <span>Au total, <?= $candidatsN ?> députés étaient candidats au <b>premier tour</b> des <?= mb_strtolower($election['libelle']) ?> de <?= $election['dateYear'] ?>.</span>
          </div>
        </div>
        <?php if ($state > 0): ?>
          <div class="d-flex flex-even px-2">
            <div class="d-flex align-items-center">
              <span class="candidatsN"><?= $candidatsN_second ?></span>
            </div>
            <div class="d-flex align-items-center ml-4">
              <span>Après le premier tour, <?= $candidatsN_second ?> députés se sont maintenus au <b>second tour</b> des <?= mb_strtolower($election['libelle']) ?> de <?= $election['dateYear'] ?>.</span>
            </div>
          </div>
        <?php endif; ?>
        <?php if ($state > 1): ?>
          <div class="d-flex flex-even px-2">
            <div class="d-flex align-items-center">
              <span class="candidatsN"><?= $candidatsN_elected ?></span>
            </div>
            <div class="d-flex align-items-center ml-4">
              <span>Après le second tour, <?= $candidatsN_elected ?> députés ont été <b>élus</b> lors des <?= mb_strtolower($election['libelle']) ?> de <?= $election['dateYear'] ?>.</span>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="row">
      <div class="pb-4 col-lg-3 search-element sticky-top sticky-top-lg">
        <div class="sticky-top sticky-offset">
          <!-- Search -->
          <div class="mt-3 mt-lg-0">
            <input type="text" id="quicksearch" placeholder="Recherchez un député..." />
          </div>
          <!-- Filters state -->
          <div class="filters filtersState mt-md-4 d-none d-lg-block">
            <p class="surtitre">Résultat de l'élection</p>
            <input class="radio-btn" name="state" id="radio-100" type="radio" checked="" value="*">
            <label for="radio-100" class="radio-label d-flex align-items-center">
              <span class="d-flex align-items-center"><b>Tous les députés</b></span>
            </label>
            <input class="radio-btn" name="state" id="radio-101" type="radio" value=".elected">
            <label for="radio-101" class="radio-label d-flex align-items-center">
              <span class="d-flex align-items-center">Élu</span>
            </label>
            <input class="radio-btn" name="state" id="radio-102" type="radio" value=".lost">
            <label for="radio-102" class="radio-label d-flex align-items-center">
              <span class="d-flex align-items-center">Éliminé</span>
            </label>
          </div>
          <!-- Filters -->
          <?php if (count($districts) <= 25): ?>
            <div class="filters filtersDistrict mt-md-5 d-none d-lg-block">
              <p class="surtitre">Région</p>
              <input class="radio-btn" name="district" id="radio-1" type="radio" checked="" value="*">
              <label for="radio-1" class="radio-label d-flex align-items-center">
                <span class="d-flex align-items-center"><b>Tous les députés</b></span>
              </label>
              <?php $i=2 ?>
              <?php foreach ($districts as $district): ?>
                <input class="radio-btn" name="district" id="radio-<?= $i ?>" type="radio" value=".<?= strtolower($district['id']) ?>">
                <label for="radio-<?= $i ?>" class="radio-label d-flex align-items-center">
                  <span class="d-flex align-items-center"><?= $district['libelle'] ?></span>
                </label>
                <?php $i++ ?>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <br>
            <select class="custom-select filters" id="selectFilter" onchange="changeFilterFunc()">
              <option selected value="*">Tous les députés</option>
              <?php foreach ($districts as $district): ?>
                <option value=".<?= $district['id'] ?>"><?= $district['libelle'] ?> (<?= $district['id'] ?>)</option>
              <?php endforeach; ?>
            </select>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-lg-9 col-md-12">
        <div class="row mt-2 sorting">
          <?php foreach ($deputes as $depute): ?>
            <div class="col-md-6 col-xl-4 sorting-item <?= strtolower($depute['districtId']) ?> <?= strtolower($depute['electionState']) ?>">
              <div class="d-flex justify-content-center">
                <?php $this->load->view('deputes/partials/card_home.php', array('depute' => $depute, 'tag' => 'h3', 'cat' => false)) ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
