<?php

\Timpack\Travian\CommandRegistry::getInstance()
    ->register('\\Timpack\\Travian\\Command\\Account\\StatusCommand')
    ->register('\\Timpack\\Travian\\Command\\Account\\LoginCommand')
    ->register('\\Timpack\\Travian\\Command\\Account\\LogoutCommand')
    ->register('\\Timpack\\Travian\\Command\\Resource\\ListCommand')
    ->register('\\Timpack\\Travian\\Command\\Village\\ListCommand');