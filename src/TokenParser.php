<?php

namespace PrinceJohn\Weave;

use Illuminate\Support\Str;
use PrinceJohn\Weave\Exceptions\BlankTokenException;
use PrinceJohn\Weave\Exceptions\MalformedTokenException;

class TokenParser
{
    protected string $key;


    /** @var string[]  */
    protected array $functions = [];


    public function __construct(protected string $token)
    {
        $cleanToken = Str::of($this->token)->between('{{', '}}')->trim();

        if(blank($cleanToken)) {
            throw new BlankTokenException;
        }

        if(Str::substrCount($cleanToken, ':') > 1) {
            throw MalformedTokenException::multipleColonDetected();
        }

        $this->key = Str::before($cleanToken, ":");


        $functionStrings = explode("|", Str::after($cleanToken, ":"));

        $this->identifyFunctions($functionStrings);
    }

    protected function identifyFunctions(array $functionStrings): void{
        if($functionStrings === []){
            return;
        }

        foreach($functionStrings as $functionString){

            $parameters = explode(',', $functionString);

            $method = array_shift($parameters);

            $this->functions[]  = [$method, $parameters];
        }
    }

    public function isGenerator(): bool{
        return $this->token === "";
    }

    public function isTransformer(): bool{
        return $this->token !== "";
    }

    public function getKey(): string{
        return $this->key;
    }

    public function getFunctions(): array{
        return $this->functions;
    }
}