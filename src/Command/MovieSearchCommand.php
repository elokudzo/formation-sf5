<?php

namespace App\Command;

use App\Omdb\OmdbClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MovieSearchCommand extends Command
{
    protected static $defaultName = 'app:movie:search';
    protected static $defaultDescription = 'Add a short description for your command';

    /**
     * @var OmdbClient
     */
    private $omdb;

    public function __construct(OmdbClient  $omdb){
        parent::__construct();
    $this->omdb    = $omdb;
    }
    protected function configure(): void
    {
        $this
            ->setName('app:movie:search')
            ->addArgument('keyword', InputArgument::OPTIONAL, 'keyword of the movie you are looking for')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $keyword = $input->getArgument('keyword');
        if(null == $keyword){
          $keyword =  $io->ask('Please enter the keyword', 'Harry',function($answer){
              $forbiddenKeywords = ['hassle', 'shit'];
              $answer = strtolower($answer);

              array_walk($forbiddenKeywords, function($keyword) use ($answer){
                 if(false !== strpos($answer,$keyword)){
                     throw new \InvalidArgumentException('Keyword not valid, please enter another one');
                 }
              });
              return $answer;
          });


        }
       $search  =  $this->omdb->requestBySearch($keyword, ['type' => 'movie']);
        $io->progressStart(count($search['Search']));

        $io->success(sprintf('%s movies found for keyword "%s"', $search['totalResults'], $keyword));
       $movies = [];
       foreach ($search['Search'] as $movie){
           $movies[] = [$movie['Title'], $movie['Year'],
               $movie['Type'], 'https://www.imdb.com/title/'.$movie['imdbID'] .'/', '<href="'.$movie['Poster'] .'">Preview</>'
               ];
           usleep(100000);
           $io->progressAdvance(1);

       }
       $io->writeln("\r\n");

        $io->table(['Title','Year', 'Type','URL','Poster'],$movies);


        return Command::SUCCESS;
    }
}
